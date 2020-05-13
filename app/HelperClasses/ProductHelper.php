<?php

namespace App\HelperClasses;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\AppModels\Product;
use App\AppModels\ProductAttribute;
use App\AppModels\ProductAttributeValue;
use App\AppModels\ProductImage;
use App\AppModels\ProductImageThumbnail;
use Illuminate\Support\Facades\Storage;
use Image;

class ProductHelper {

  // store product basic info in session
  public static function saveBasic($request) {
    $data = $request->validate([
      'brand_id' => 'required|digits_between:1,9|exists:brands,id',
      'category_id' => 'required|digits_between:1,9|exists:categories,id',
      'sku' => 'nullable|max:255|unique:products,sku',
      'title' => 'required|max:255',
      'slug' => 'required|max:255|unique:products,slug',
      'description' => 'required|max:50000000',
      'supplier_details' => 'nullable|max:50000'
    ]);

    $p = Product::find(session()->get('product_draft_id'));
    // if not found create one
    if (!$p) $p = new Product();
    $p->brand_id = $data['brand_id'];
    $p->category_id = $data['category_id'];
    $p->sku = $data['sku'];
    $p->title = $data['title'];
    $p->slug = $data['slug'];
    $p->description = $data['description'];
    $p->supplier_details = $data['supplier_details'];
    $p->is_active = -1; // -1 = draft
    if ($p->save()){
      // store product id in session
      session(['product_draft_id' => $p->id]);
      return response()->json(['msg' => 'Basic has been stored.'], 200);
    }
    return response()->json(['msg' => 'Error! unable to store.'], 401);
  }


  // store product seo info in session
  public static function saveSEO($request) {
    $data = $request->validate([
      'meta_title' => 'required|max:191',
      'meta_keywords' => 'required|max:191',
      'meta_description' => 'required|max:191'
    ]);

    // store in session
    $p = Product::findOrFail(session()->get('product_draft_id'));
    $p->meta_title = $data['meta_title'];
    $p->meta_keywords = $data['meta_keywords'];
    $p->meta_description = $data['meta_description'];
    if ($p->save()){
      return response()->json(['msg' => 'SEO has been stored.'], 200);
    return response()->json(['msg' => 'Error! unable to store.'], 401);
    }
  }


  // store product attribute info in session
  public static function saveAttribute($request) {
    $data = $request->validate([
      'has_attribute' => 'required|max:3',
      'attribute_key.*' => 'required',
      'attribute_value.*' => 'required',
    ], [
      'attribute_key.0.required' => 'Attribute key is required',
      'attribute_value.0.required' => 'Attribute value is required'
    ]);

    // flag
    $stored = false;
    // store in session
    $p = Product::findOrFail(session()->get('product_draft_id'));
    $p->has_attribute = ($data['has_attribute'] == 'yes') ? 1 : 0;
    $stored = $p->save();

    if ($stored && $data['has_attribute']) {
      foreach ($data['attribute_key'] as $key => $att_key) {
        $pro_att = new ProductAttribute();
        $pro_att->product_id = $p->id;
        $pro_att->key = $att_key;
        $stored = $pro_att->save();

        // store attribute values
        $att_values = explode(",", $data['attribute_value'][$key]);
        foreach ($att_values as $att_value) {
          $att_val = new ProductAttributeValue();
          $att_val->product_attribute_id = $pro_att->id;
          $att_val->value = $att_value;
          $stored = $att_val->save();
        }
      }
    }

    if ($stored){
      return response()->json(['msg' => 'Attributes have been stored.'], 200);
    return response()->json(['msg' => 'Error! unable to store.'], 401);
    }
  }


  // store product price info in session
  public static function savePrice($request) {
    $data = '';
    if ($request->has_discount == 'yes') {
      $data = $request->validate([
        'buy_price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
        'sale_price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
        'stock' => 'required|digits_between:1,9',
        'has_discount' => 'required|max:3',
        'discount_type' => 'required|max:7',
        'discount_amount' => 'required|regex:/^\d+(\.\d{1,2})?$/'
      ]);
    } else {
      $data = $request->validate([
        'buy_price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
        'sale_price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
        'stock' => 'required|digits_between:1,9',
        'has_discount' => 'required|max:3',
        'discount_type' => 'nullable|max:7',
        'discount_amount' => 'nullable|regex:/^\d+(\.\d{1,2})?$/'
      ]);
    }

      // store in session
      $p = Product::findOrFail(session()->get('product_draft_id'));
      $p->buy_price = $data['buy_price'];
      $p->sale_price = $data['sale_price'];
      $p->stock = $data['stock'];
      if ($data['has_discount'] == 'yes') $p->has_discount = 1;
      else $p->has_discount = 0;
      $p->discount_type = $data['discount_type'];
      if ($data['discount_type'] == 'fixed') $p->discount_fixed_price = $data['discount_amount'];
      else $p->discount_percent = $data['discount_amount'];

      if ($p->save())
        return response()->json(['msg' => 'Price has been stored.'], 200);
      return response()->json(['msg' => 'Error! unable to store.'], 401);
  }


  // store product images
  public static function saveProductImage($request) {
    $request->validate([
      'product_images' => 'array',
      'product_images.*' => 'required|image|mimes:png,jpeg,jpg|max:10000'
    ]);

    $stored = false;
    $total_images = count($request->file('product_images'));
    $image_names = array();
    $image_thumb = '';
    for ($i=0; $i < $total_images; $i++) {
      // store image
      $path = $request->file('product_images')[$i]->storeAs(
          'public/product_images',
          'product_img_'.time().'_'.mt_rand().'_'.session('product_basic')['slug'].'_'.$i.'.'.$request->file('product_images')[$i]->extension()
      );
      // push only image name
      array_push($image_names, basename($path));
    }

    // if already thumnail created then ignore
    // make thumnail of first images
    $p = Product::findOrFail(session()->get('product_draft_id'));
    if (!isset($p->thumbnail->thumbnail)) {
      $image = storage_path('app/public/product_images/'.$image_names[0]);
      $destinationPath = storage_path('/app/public/product_thumbs');

      $img = Image::make($image);
      $img->resize(266, 266, function ($constraint) {
          $constraint->aspectRatio();
      })->save($destinationPath.'/thumb_'.$image_names[0]);

      $t = new ProductImageThumbnail();
      $t->product_id = $p->id;
      $t->thumbnail = 'thumb_'.$image_names[0];
      $stored = $t->save();
    }

    foreach ($image_names as $image_name) {
      $img = new ProductImage();
      $img->product_id = $p->id;
      $img->image = $image_name;
      $img->save();
    }

    if ($stored)
      return response()->json(['msg' => 'Images have been stored.'], 200);
    return response()->json(['msg' => 'Error! unable to store.'], 401);
  }


  /*
  * Store product
  */
  public static function publishProduct($request, $update = false, $id = NULL) {
    $p = Product::findOrFail(session()->get('product_draft_id'));
    $p->is_active = $request->is_active;
    if ($p->save()){
      session(['product_draft_id' => null]);
      return redirect()->back()->withSuccess('Product has been stored.');
    }
    return redirect()->back()->withFail('Error! unable to store.');
  }


  // params-> formdata, product_id
  public static function updateBasic($d, $id) {
    $p = Product::findOrFail($id);
    $p->brand_id = $d['brand_id'];
    $p->category_id = $d['category_id'];
    $p->sku = $d['sku'];
    $p->title = $d['title'];
    $p->slug = $d['slug'];
    $p->description = $d['description'];
    $p->supplier_details = $d['supplier_details'];

    if ($p->save())
      return redirect()->back()->withSuccess("Product has been Updated");
    // if failed to delete return err msg.
    return redirect()->back()->withFail("Somthing wrong!");
  }


  // params-> formdata, product_id
  public static function updatePrice($d, $id) {
    $p = Product::findOrFail($id);
    $p->buy_price = $d['buy_price'];
    $p->sale_price = $d['sale_price'];
    $p->stock = $d['stock'];
    $p->has_discount = $d['has_discount'];
    $p->discount_type = $d['discount_type'];

    if($d['discount_type'] == 'fixed')
      $p->discount_fixed_price = $d['discount_amount'];

    if($d['discount_type'] == 'percent')
      $p->discount_percent = $d['discount_amount'];

    if ($p->save())
      return redirect()->back()->withSuccess("Prices have been Updated");
    // if failed to delete return err msg.
    return redirect()->back()->withFail("Somthing wrong!");
  }


  // params-> formdata, product_id
  public static function updateAttribute($d, $id) {
    $status = false;

    // attributes
    if (is_array($d['attribute_key']) && count($d['attribute_key']) > 0) {
      foreach ($d['attribute_key'] as $key => $att_key) {
        if (empty($att_key)) continue;

        $att = ProductAttribute::where('product_id', $id)->where('key', $att_key)->first();

        // create if not found
        if(!$att)
          $att = new ProductAttribute();

        $att->product_id = $id;
        $att->key = $att_key;
        $status = $att->save();

        // store attribute values
        $att_values = explode(",", $d['attribute_value'][$key]);
        foreach ($att_values as $att_value) {
          $att_val = ProductAttributeValue::where('value', $att_value)->where('product_attribute_id', $att->id)->first();

          // create if not found
          if(!$att_val)
            $att_val = new ProductAttributeValue();

          $att_val->product_attribute_id = $att->id;
          $att_val->value = $att_value;
          $status = $att_val->save();
        }
      }
    }


    if ($status)
      return redirect()->back()->withSuccess("Attributes have been Updated");
    // if failed to delete return err msg.
    return redirect()->back()->withFail("Somthing wrong!");
  }


  // params-> formdata, product_id
  public static function updateSEO($d, $id) {
    $p = Product::findOrFail($id);
    $p->meta_title = $d['meta_title'];
    $p->meta_keywords = $d['meta_keywords'];
    $p->meta_description = $d['meta_description'];

    if ($p->save())
      return redirect()->back()->withSuccess("Product SEO has been Updated");
    // if failed to delete return err msg.
    return redirect()->back()->withFail("Somthing wrong!");
  }



  // params-> formdata, product_id
  public static function updateProductImage($request, $id) {
    $request->validate([
      'product_images' => 'array',
      'product_images.*' => 'required|image|mimes:png,jpeg,jpg|max:10000'
    ]);

    $status = false;
    $total_images = count($request->file('product_images'));
    $image_names = array();

    for ($i=0; $i < $total_images; $i++) {
      // store image
      $path = $request->file('product_images')[$i]->storeAs(
          'public/product_images',
          'product_img_'.time().'_'.mt_rand().'_'.$id.'_.'.$request->file('product_images')[$i]->extension()
      );

      // push only image name
      array_push($image_names, basename($path));
    }

    // store images in db
    foreach ($image_names as $image_name) {
      $img = new ProductImage();
      $img->product_id = $id;
      $img->image = $image_name;
      $status = $img->save();
    }

    // if Thumbnail not found create one, by taking first image
    // make thumnail of first images
    if(!ProductImageThumbnail::where('product_id', $id)->exists()){
      $image = storage_path('app/public/product_images/'.$image_names[0]);
      $destinationPath = storage_path('/app/public/product_thumbs');

      $img = Image::make($image);
      $img->resize(320, 320, function ($constraint) {
          $constraint->aspectRatio();
      })->save($destinationPath.'/thumb_'.$image_names[0]);

      // thumbnails
      $pr_img_th = new ProductImageThumbnail();
      $pr_img_th->product_id = $id;
      $pr_img_th->thumbnail = 'thumb_'.$image_names[0];
      $status = $pr_img_th->save();
    }

    if ($status)
      return redirect()->back()->withSuccess("Product SEO has been Updated");
    // if failed to delete return err msg.
    return redirect()->back()->withFail("Somthing wrong!");
  }



}

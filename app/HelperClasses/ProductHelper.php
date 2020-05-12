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
      'sku' => 'nullable|max:191|unique:products,sku',
      'title' => 'required|max:191',
      'slug' => 'required|max:191|unique:products,slug',
      'description' => 'required|max:50000',
      'supplier_details' => 'nullable|max:50000'
    ]);

    // store in session
    session(['product_basic' => $data]);

    // return success if saved
    if (session()->has('product_basic')) {
      $flash_msg = [
        'class' => 'alert-success',
        'title' => 'Success',
        'msg' => 'Product Basic has been added successfully.'
      ];

      return response()->json([
        'status'=>true,
        'html'=>view('admin.parts.flash')->with('flash_msg', $flash_msg)->render()
      ]);
    }
  }


  // store product seo info in session
  public static function saveSEO($request) {
    $data = $request->validate([
      'meta_title' => 'required|max:191',
      'meta_keywords' => 'required|max:191',
      'meta_description' => 'required|max:191',
    ]);

    // store in session
    session(['product_seo' => $data]);

    // return success msg if saved
    if (session()->has('product_seo')) {
      $flash_msg = [
        'class' => 'alert-success',
        'title' => 'Success',
        'msg' => 'SEO details has been added successfully.'];

      return response()->json([
        'status'=>true,
        'html'=>view('admin.parts.flash')->with('flash_msg', $flash_msg)->render()
      ]);
    }

  }


  // store product attribute info in session
  public static function saveAttribute($request) {
    $data = $request->validate([
      'has_attribute' => 'required|max:3',
      'attribute_key' => 'required',
      'attribute_value' => 'required',
    ]);

    if ($data['has_attribute'] === "yes") {
      // store attributes in session
      session(['product_attribute' => $data]);

      // return success if saved
      if (session()->has('product_attribute')) {
        $flash_msg = [
          'class' => 'alert-success',
          'title' => 'Success',
          'msg' => 'Attributes has been added successfully.'
        ];

        return response()->json([
          'status'=>true,
          'html'=>view('admin.parts.flash')->with('flash_msg', $flash_msg)->render()
        ]);
      }
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

    }else {
      $data = $request->validate([
        'buy_price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
        'sale_price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
        'stock' => 'required|digits_between:1,9',
        'has_discount' => 'required|max:3',
        'discount_type' => 'nullable|max:7',
        'discount_amount' => 'nullable|regex:/^\d+(\.\d{1,2})?$/'
      ]);
    }

    // store price in session
    session(['product_price' => $data]);

    // return success msg if has price stored
    if (session()->has('product_price')) {
      $flash_msg = [
        'class' => 'alert-success',
        'title' => 'Success',
        'msg' => 'Price has been added successfully.'
      ];

      return response()->json([
        'status'=>true,
        'html'=>view('admin.parts.flash')->with('flash_msg', $flash_msg)->render()
      ]);
    }
  }


  // store product seo info in session
  public static function saveProductImage($request) {
    $request->validate([
      'product_images' => 'array',
      'product_images.*' => 'required|image|mimes:png,jpeg,jpg|max:10000'
    ]);

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
    if (empty(session()->get('product_image_thumb'))) {
      $image = storage_path('app/public/product_images/'.$image_names[0]);
      $destinationPath = storage_path('/app/public/product_thumbs');

      $img = Image::make($image);
      $img->resize(266, 266, function ($constraint) {
          $constraint->aspectRatio();
      })->save($destinationPath.'/thumb_'.$image_names[0]);
      session(['product_image_thumb' => 'thumb_'.$image_names[0]]);
    }

    // store images in session
    session(['product_images' => $image_names]);

    $flash_msg = [
      'class' => 'alert-success',
      'title' => 'Success',
      'msg' => 'Image(s) has been added successfully.'
    ];

    return response()->json([
      'status'=>true,
      'images' => view('admin.parts.uploaded_images')->render(),
      'html'=>view('admin.parts.flash')->with('flash_msg', $flash_msg)->render()
    ]);
  }


  /*
  * Store product
  */
  public static function publishProduct($request, $update = false, $id = NULL) {

      // get product individual parts from session
      $product_basic       = session()->get('product_basic');
      $product_seo         = session()->get('product_seo');
      $product_attribute   = session()->get('product_attribute');
      $product_price       = session()->get('product_price');
      $product_images      = session()->get('product_images');
      $product_image_thumb = session()->get('product_image_thumb');

      if (empty($product_basic)  ||
          empty($product_price)  ||
          empty($product_images) ||
          empty($product_image_thumb))
          return redirect()->back()->withFail("Somthing wrong! Please try again.");


      // err, if sku already exists.
      if ($product_basic['sku'] == "" || $product_basic['sku'] == "null" || $product_basic['sku'] == null) {

      }else {
        if(Product::where('sku', $product_basic['sku'])->exists())
          return redirect()->back()->withFail("SKU already exists!");
      }

      // check is called for updating or creating?
      $product = new Product();
      $product->category_id = $product_basic['category_id'];
      $product->brand_id = $product_basic['brand_id'];
      $product->sku = $product_basic['sku'];
      $product->title = $product_basic['title'];
      $product->slug = $product_basic['slug'];
      $product->description  = $product_basic['description'];
      $product->supplier_details  = $product_basic['supplier_details'];
      $product->buy_price = $product_price['buy_price'];
      $product->sale_price = $product_price['sale_price'];
      $product->stock = $product_price['stock'];

      if (isset($product_attribute['has_attribute'])) {
        $product->has_attribute = (int) $product_attribute['has_attribute'];
      }

      $product->has_discount = (int) $product_price['has_discount'];
      $product->discount_type = $product_price['discount_type'];

      if($product->discount_type == 'fixed')
        $product->discount_fixed_price = $product_price['discount_amount'];

      if($product->discount_type == 'percent')
        $product->discount_percent = $product_price['discount_amount'];

      $product->is_active = (int) $request->is_active;

      if (isset($product_seo['meta_title'])) {
        $product->meta_title = $product_seo['meta_title'];
        $product->meta_keywords = $product_seo['meta_keywords'];
        $product->meta_description = $product_seo['meta_description'];
      }
      $product->save();


      // attributes
      $k = "";
      if (!empty($product_attribute) && count($product_attribute) > 0) {
        foreach ($product_attribute['attribute_key'] as $key => $att_key) {
          if ($k == $att_key) continue;

          $pro_att = new ProductAttribute();
          $pro_att->product_id = $product->id;
          $pro_att->key = $att_key;
          $pro_att->save();
          $k = $att_key;

          // store attribute values
          $att_values = explode(",", $product_attribute['attribute_value'][$key]);
          foreach ($att_values as $att_value) {
            $att_val = new ProductAttributeValue();
            $att_val->product_attribute_id = $pro_att->id;
            $att_val->value = $att_value;
            $att_val->save();
          }
        }
      }



      // images
      if (is_array($product_images)) {
        foreach ($product_images as $product_image) {
          $product_img = new ProductImage();
          $product_img->product_id = $product->id;
          $product_img->image = $product_image;
          $product_img->save();
        }
      }


      // thumbnails
      $pr_img_th = new ProductImageThumbnail();
      $pr_img_th->product_id = $product->id;
      $pr_img_th->thumbnail = $product_image_thumb;
      $pr_img_th->save();


      if (true) {
        session(['product_basic' => array()]);
        session(['product_seo' => array()]);
        session(['product_attribute' => array()]);
        session(['product_price' => array()]);
        session(['product_images' => array()]);
        session(['product_image_thumb' => array()]);
        return redirect()->back()->withSuccess("Product has been Added");
      }

      // if failed to delete return err msg.
      return redirect()->back()->withFail("Somthing wrong!");

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

<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\AppModels\Brand;
use App\AppModels\Product;
use App\HelperClasses\ProductHelper;
use App\AppModels\ProductAttribute;
use App\AppModels\ProductAttributeValue;
use App\AppModels\ProductImage;
use App\AppModels\ProductImageThumbnail;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller {

  // show product list
  public function index() {
    // $_GET['']
    $products = Product::orderBy('id', 'DESC')->paginate(15);
    return view('admin.products.products', compact('products'));
  }

  // show product createform
  public function create() {
    // get brands, to display on product create form
    $brands = Brand::all();
    return view('admin.products.product_create_form', compact('brands'));
  }


  // store products in session
  public function store(Request $request) {

    // store product individual form input in session
    if (isset($request->for)) {
      switch ($request->for) {
        // store basic in session
        case 'save_basic':
          return ProductHelper::saveBasic($request);
          break;

        // store price in session
        case 'save_price':
          return ProductHelper::savePrice($request);
          break;

        // store price in session
        case 'save_attribute':
          return ProductHelper::saveAttribute($request);
          break;

        // store price in session
        case 'save_seo':
          return ProductHelper::saveSEO($request);
          break;

        //store image in session
        case 'save_image':
          return ProductHelper::saveProductImage($request);
          break;

        // publish product
        case 'publish_product':
          return ProductHelper::publishProduct($request);
          break;

        default:
          return abort(404);
          break;
      }
    }

    // err, if nothing mactched above.
    return abort(404);
  }



  // show single product
  public function show($id) {
      return "product show ".$id;
  }


  // edit single product
  public function edit($id) {
    $breadcrumb['title'] = "Product Edit Form";
    $product = Product::findOrFail($id);
    $brands = Brand::all();
    return view('admin.products.product_edit_form', compact('breadcrumb', 'product', 'brands'));
  }


  // update single product
  public function update(Request $request, $id) {

    // store product individual form input in session
    if (isset($request->for)) {
      switch ($request->for) {
        // store basic in session
        case 'update_basic':
          // validate
          $d = $request->validate([
            'product_id' => 'required|digits_between:1,9|exists:products,id',
            'brand_id' => 'required|digits_between:1,9|exists:brands,id',
            'category_id' => 'required|digits_between:1,9|exists:categories,id',
            'sku' => 'nullable|max:191',
            'title' => 'required|max:191',
            'slug' => 'required|max:191',
            'description' => 'required|max:50000',
            'supplier_details' => 'nullable|max:50000'
          ]);

          return ProductHelper::updateBasic($d, $id);
          break;

        // store price in session
        case 'update_price':
          // validate
          $d = $request->validate([
            'product_id' => 'required|digits_between:1,9|exists:products,id',
            'buy_price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'sale_price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'stock' => 'required|digits_between:1,9',
            'has_discount' => 'required|max:1',
            'discount_type' => 'nullable|max:7',
            'discount_amount' => 'nullable|regex:/^\d+(\.\d{1,2})?$/'
          ]);

          return ProductHelper::updatePrice($d, $id);
          break;

        // store price in session
        case 'update_attribute':
          $d = $request->validate([
            'product_id' => 'required|digits_between:1,9|exists:products,id',
            'has_attribute' => 'required|max:1',
            'attribute_key' => 'required',
            'attribute_value' => 'required'
          ]);
          return ProductHelper::updateAttribute($d, $id);
          break;

        // store price in session
        case 'update_seo':
          $d = $request->validate([
            'meta_title' => 'required|max:191',
            'meta_keywords' => 'required|max:191',
            'meta_description' => 'nullable|max:255'
          ]);

          return ProductHelper::updateSEO($d, $id);
          break;

        //store image in session
        case 'update_image':
          return ProductHelper::updateProductImage($request, $id);
          break;

        // publish product
        case 'update_publish':
          $d = $request->validate([
            'for' => 'required|max:15',
            'is_active' => 'required|digits_between:0,1|max:1'
          ]);

          $p = Product::findOrFail($id);
          $p->is_active = (int)$d['is_active'];
          if ($p->save())
            return redirect()->back()->withSuccess("Product publish status has been Updated");
          // if failed to delete return err msg.
          return redirect()->back()->withFail("Somthing wrong!");
          break;

        default:
          return abort(404);
          break;
      }
    }

    return abort(404);
  }


  // delete single product
  public function destroy($id, Request $request) {
    // delete single image
    if($request->for == 'destroy_image') {
      $img = ProductImage::where('product_id', $id)->findOrFail($request->image_id);
      Storage::disk('public')->delete('product_images/'.$img->image);
      if ($img->delete())
        return redirect()->back()->withSuccess("Image has been Deleted.");
    }

    // delete thumbnail
    if($request->for == 'destroy_thumb') {
      $thumb = ProductImageThumbnail::where('product_id', $id)->findOrFail($request->thumb_id);
      Storage::disk('public')->delete('product_thumbs/'.$thumb->thumbnail);
      if ($thumb->delete())
        return redirect()->back()->withSuccess("Thumbnail has been Deleted.");
    }


      $p = Product::findOrFail($id);
      // delete product attributes
      foreach ($p->attributes as $at) {
        foreach ($at->values as $v) {
          $v->delete();
        }
        $at->delete();
      }

      // delete product thumbnail
      if ($p->thumbnail) {
        $p->thumbnail->delete();
      }
      Storage::disk('public')->delete('product_thumbs/'.$p->thumbnail->thumbnail);

      // delete product images
      foreach ($p->images as $img) {
        $img->delete();
        Storage::disk('public')->delete('product_images/'.$img->image);
      }

      if ($p->delete())
        return redirect()->back()->withSuccess("Product has been Deleted.");

      // if failed to delete return err msg.
      return redirect()->back()->withFail("Somthing wrong! can't delete.");
  }

}

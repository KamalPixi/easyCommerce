<?php

namespace App\Http\Controllers\AppControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\AppModels\Category;
use App\AppModels\Product;
use App\AppModels\Slider;
use App\AppModels\Order;
use App\AppModels\Review;
use App\AppModels\OrderMaster;
use App\AppModels\PopUpBanner;
use App\HelperClasses\Helper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AppController extends Controller
{
    public function index(){
      $main_products = Product::where('is_active', 1)->take(12)->get();
      $top_products = Product::where('is_active', 1)->inRandomOrder()->limit(10)->get();
      $sliders = Slider::where('is_active', 1)->get();
      $popup_banner = PopUpBanner::where('show_on_page', 'home')->where('publish', 1)->first();

      return view('app.index', compact('main_products', 'top_products', 'sliders', 'popup_banner'));
    }


    // get single product
    public function product($slug) {
      // get the product
      $product = Product::where('slug', $slug)->where('is_active', 1)->firstOrFail();
      $sub_categories = Helper::getCategories($product);
      // get reviews
      $reviews = Review::where('is_approved', 1)->get();

      // has user bought this product
      $user_bought_this = false;
      if (auth()->check()) {
        $user_bought_this = auth()->user()->hasBoughtThisProduct($product->id);
      }


      // increse view
      $product->viewed += 1;
      $product->save();

      // return view
      return view('app.products.product', compact('product', 'sub_categories', 'user_bought_this', 'reviews'));
    }



    public function search(Request $request) {
      $d = $request->validate([
        'keyword' => 'required|max:191'
      ]);

      $products = Product::Where('title', 'LIKE', "%{$d['keyword']}%")->get();
      // id Request is ajax
      if ($request->ajax())
        return view('app.search_result_show', compact('products'));

      $keyword = $d['keyword'];
      return view('app.search', compact('products', 'keyword'));

    }



    // return things based on what looking for
    public function get(Request $request) {
      // switch
      switch ($request->for) {

        // create slug
        case 'create_slug':
          $data = $request->validate(['title' => 'required|max:191']);
          return Str::slug($data['title'].'-'.mt_rand());
          break;

        // returns child subcategories(lvl2) in html
        case 'subcategories':
          $data = $request->validate(['category_id' => 'required|digits_between:1,10']);
          $categories = Category::where('category_id', $data['category_id'])->get();
          return view('admin.category.getCategories', compact('categories'));
          break;

        // returns child subcategories(lvl2) in html
        case 'categories_by_name':
          $data = $request->validate(['name' => 'nullable|max:191']);
          $categories = Category::where('name', 'LIKE', $data['name'].'%')->get();
          return view('admin.category.getCategoriesByName', compact('categories'));
          break;

          // returns attribute div row html
          case 'attribute_div':
            return view('admin.parts.attribute_div');
            break;

          // returns attribute div row html
          case 'is_user_logged_in':
            return ['message'=>(Auth::guard('web')->check()) ? true : false, 'shipping_method' => ''];
            break;

        default:
          return "somthing wrong.";
          break;
      }

    }


}

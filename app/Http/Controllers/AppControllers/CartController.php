<?php

namespace App\Http\Controllers\AppControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\HelperClasses\Helper;
use App\AppModels\Product;
use App\AppModels\ShippingMethod;

class CartController extends Controller {
    public function cart(Request $request) {
      // delete cart
      if ($request->delete) {
        $d = $request->validate(['delete' => 'bail|required|numeric|min:1']);
        return Helper::removeFromCart($d['delete'], $request);
      }

      // get product id from session
      $carts = session()->get('cart');
      $product_ids = array();
      if(is_array($carts)){
        foreach ($carts as $cart) {
          array_push($product_ids, $cart['product_id']);
        }
      }
      $products = Product::find($product_ids);

      // get shipping methods
      $shipping_methods = ShippingMethod::where('is_active', 1)->get();

      return view('app.cart', compact('products', 'shipping_methods'));
    }


    public function addToCart(Request $request) {

      // update cart. if request made for updating an item from cart
      if ($request->update) {
        $d = $request->validate([
          'update' => 'required|min:4|max:4',
          'product_id' => 'required|array',
          'product_id.*' => 'bail|required|numeric|min:1|gt:0|exists:products,id',
          'qty' => 'required|array',
          'qty.*' => 'bail|required|numeric|min:1|gt:0'
        ]);
        return Helper::updateCart($d);
      }


      //add shipping method. if request made for adding shipping method
      if ($request->shipping_method_id) {
        $d = $request->validate([
          'shipping_method_id' => 'bail|required|numeric|min:1|gt:0|exists:shipping_methods,id',
        ]);
        session()->put('shipping_method_id', $d['shipping_method_id']);
        session()->save();

        // calculate total price of cart including shipping cost
        $subtotal = 0;
        $sm = ShippingMethod::findOrFail($d['shipping_method_id']);
        $subtotal += $sm->cost;
        $carts = session()->get('cart');
        $product_ids = array();
        foreach ($carts as $cart) {
          array_push($product_ids, $cart['product_id']);
        }
        $products = Product::find($product_ids);
        foreach ($products as $k => $p) {
          $subtotal += $p->sale_price * $carts[$k]['qty'];
        }
        return response(['subtotal'=> $subtotal], 200);
      }

      $d = $request->validate([
        'product_id' => 'bail|required|numeric|min:1|gt:0|exists:products,id',
        'qty' => 'bail|nullable|numeric|min:1|gt:0',
        'attribute_value_id' => 'nullable|array',
        'attribute_value_id.*' => 'bail|nullable|numeric|min:1|distinct|gt:0'
      ]);

      // if cart already exists then update cart else create cart in session,
      if (session()->has('cart')) {
        $carts = session()->get('cart');
        $carts_new = array();
        $cart_found = false;
        // replace the item from cart, if product_id already exists,
        foreach ($carts as $cart) {
          if ($cart['product_id'] == $d['product_id']) {
              $cart['qty'] = $d['qty'];
              if (isset($d['attribute_value_id'])) $cart['att_value_ids'] = $d['attribute_value_id'];
              else $cart['att_value_ids'] = array();
              array_push($carts_new, $cart);
              $cart_found = true;
          }else {
            array_push($carts_new, $cart);
          }
        }

        // push new cart
        if (!$cart_found) {
          $cart_new = array('product_id'=>0, 'qty' => 0, 'att_value_ids' => array());
          $cart_new['product_id'] = $d['product_id'];
          $cart_new['qty'] = $d['qty'];
          if (isset($d['attribute_value_id'])) $cart_new['att_value_ids'] = $d['attribute_value_id'];
          else $cart_new['att_value_ids'] = array();
          array_push($carts_new, $cart_new);
        }
        session(['cart' => $carts_new]);
      } else {
        $carts = array();
        $cart = array('product_id'=>0, 'qty' => 0, 'att_value_ids' => array());
        $cart['product_id'] = $d['product_id'];
        $cart['qty'] = $d['qty'];
        if (isset($d['attribute_value_id'])) $cart['att_value_ids'] = $d['attribute_value_id'];
        else $cart['att_value_ids'] = array();
        array_push($carts, $cart);
        session(['cart' => $carts]);
      }


      if ($request->ajax()) {
        return response()->json([
          'cart' => view('app.includes.cart_list')->render()
        ]);
      }

      return redirect()->back()->withSuccess("Item has been added.");
    }
}

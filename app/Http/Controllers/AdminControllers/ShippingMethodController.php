<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\AppModels\ShippingMethod;

class ShippingMethodController extends Controller {

    // show brands
    public function index() {
      $shipping_methods = ShippingMethod::all();
      return view('admin.shipping_methods.show', compact('shipping_methods'));
    }

    // show brand create form
    public function create() {
      return view('admin.shipping_methods.create_form');
    }


    // create a brand
    public function store(Request $request) {
      $d = $request->validate([
        'name' => 'required|max:191|unique:App\AppModels\ShippingMethod,name',
        'minimum_amount' => 'required|regex:/^\d+(\.\d{1,2})?$/',
        'description' => 'nullable|max:2000',
        'cost' => 'required|regex:/^\d+(\.\d{1,2})?$/',
        'is_active' => 'required|digits_between:0,1'
      ]);

      $s = new ShippingMethod();
      $s->name = $d['name'];
      $s->minimum_amount = $d['minimum_amount'];
      $s->description = $d['description'];
      $s->cost = $d['cost'];
      $s->is_active = (int) $d['is_active'];

      if ($s->save())
        return redirect()->back()->withSuccess($d['name'] . " has been created.");

      // if failed to delete return err msg.
      return redirect()->back()->withFail("Somthing wrong! can't create brand.");
    }


    public function show($id) {
        //
    }



    // show brand edit form
    public function edit($id) {
      $shipping_method = ShippingMethod::findOrFail($id);
      return view('admin.shipping_methods.edit_form', compact('shipping_method'));
    }



    // update brand
    public function update(Request $request, $id) {
      $d = $request->validate([
        'name' => 'required|max:191',
        'minimum_amount' => 'required|regex:/^\d+(\.\d{1,2})?$/',
        'description' => 'nullable|max:2000',
        'cost' => 'required|regex:/^\d+(\.\d{1,2})?$/',
        'is_active' => 'required|digits_between:0,1'
      ]);

      $s = ShippingMethod::findOrFail($id);
      $s->name = $d['name'];
      $s->minimum_amount = $d['minimum_amount'];
      $s->description = $d['description'];
      $s->cost = $d['cost'];
      $s->is_active = (int) $d['is_active'];

      if ($s->save())
        return redirect()->back()->withSuccess($d['name'] . " has been Updated.");

      // if failed to delete return err msg.
      return redirect()->back()->withFail("Somthing wrong! can't update brand.");
    }


    // delete barnd
    public function destroy($id) {
      $s = ShippingMethod::findOrFail($id);
      if ($s->delete())
        return redirect()->back()->withSuccess("Has been Deleted.");

      // if failed to delete return err msg.
      return redirect()->back()->withFail("Somthing wrong! can't delete.");
    }

}

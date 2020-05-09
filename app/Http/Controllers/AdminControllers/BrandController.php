<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\AppModels\Brand;

class BrandController extends Controller {

    // show brands
    public function index() {
      $brands = Brand::all();
      return view('admin.brands.brands', compact('brands'));
    }

    // show brand create form
    public function create() {
      return view('admin.brands.brand_create_form');
    }


    // create a brand
    public function store(Request $request) {
      $data = $request->validate([
        'brand_name' => 'required|max:191|unique:App\AppModels\Brand,name'
      ]);

      $brand = new Brand();
      $brand->name = $data['brand_name'];
      if ($brand->save())
        return redirect()->back()->withSuccess($data['brand_name'] . " has been created.");

      // if failed to delete return err msg.
      return redirect()->back()->withFail("Somthing wrong! can't create brand.");
    }


    public function show($id) {
        //
    }



    // show brand edit form
    public function edit($id) {
      $brand = Brand::findOrFail($id);
      return view('admin.brands.brand_edit_form', compact('brand'));
    }



    // update brand
    public function update(Request $request, $id) {
      $data = $request->validate([
        'brand_name' => 'required|max:191'
      ]);

      $brand = Brand::findOrFail($id);
      $brand->name = $data['brand_name'];
      if ($brand->save())
        return redirect()->back()->withSuccess($data['brand_name'] . " has been Updated.");

      // if failed to delete return err msg.
      return redirect()->back()->withFail("Somthing wrong! can't update brand.");
    }


    // delete barnd
    public function destroy($id) {
      $brand = Brand::findOrFail($id);
      if ($brand->delete())
        return redirect()->back()->withSuccess("Brand has been Deleted.");

      // if failed to delete return err msg.
      return redirect()->back()->withFail("Somthing wrong! can't delete brand.");
    }

}

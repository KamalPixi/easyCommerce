<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\AppModels\Category;
use Illuminate\Support\Str;
use App\HelperClasses\SubSubCategoryHelper;

class SubSubCategoryController extends Controller {

    public function index() {
      //get categories that has no parent
      $categories = Category::whereNull('category_id')->get();
      return view('admin.category.show_sub_subcategories', compact('categories'));
    }


    public function create() {
      $categories = Category::whereNull('category_id')->get();
      return view('admin.category.sub_subcategory_create_form', compact('categories'));
    }


    public function store(Request $request) {
      // validate form
      $data = $request->validate([
          'subcategory_id' => 'required|digits_between:1,10|exists:categories,id',
          'sub_subcategory_name' => 'required|max:191',
          'sub_subcategory_slug' => 'required|max:191|regex:/^\S*$/u|unique:categories,slug',
          'meta_title' => 'nullable|max:191',
          'meta_desc' => 'nullable|max:1000',
          'status' => 'required|integer|between:0,1'
      ]);

      if (SubSubCategoryHelper::storeSubSubCategory($data))
      return redirect()->back()->withSuccess($data['sub_subcategory_name'] . " has been created.");

      // if failed to delete return err msg.
      return redirect()->back()->withFail("Somthing wrong! can't create sub-subcategory");
    }


    public function show($id) {
        //
    }


    public function edit($id) {
      $sub_sub_category = Category::whereNotNull('category_id')->findOrFail($id);
      $categories = Category::whereNull('category_id')->get();
      return view('admin.category.sub_subcategory_edit_form', compact('categories', 'sub_sub_category'));
    }


    public function update(Request $request, $id) {
      $data = $request->validate([
          'subcategory_id' => 'required|digits_between:1,10|exists:categories,id',
          'sub_subcategory_name' => 'required|max:191',
          'sub_subcategory_slug' => 'required|max:191|regex:/^\S*$/u|unique:categories,slug',
          'meta_title' => 'nullable|max:191',
          'meta_desc' => 'nullable|max:1000',
          'status' => 'required|integer|between:0,1'
      ]);

      // update category
      if (SubSubCategoryHelper::updateSubSubCategory($data, $id))
        return redirect()->back()->withSuccess($data['sub_subcategory_name'] . " has been Updated.");

      // if failed to update return err msg.
      return redirect()->back()->withFail("Somthing wrong! can't update sub-subcategory");
    }


    public function destroy($id) {
      $sub_subcategory = Category::whereNotNull('category_id')->findOrFail($id);

      //delete subcategory
      if ($sub_subcategory->delete())
        return redirect()->back()->withSuccess($sub_subcategory->name . " has been deleted.");

      return redirect()->back()->withFail("Somthing wrong! can't delete sub-subcategory.");
    }

}

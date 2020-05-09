<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\AppModels\Category;
use Illuminate\Support\Str;
use App\HelperClasses\SubCategoryHelper;

class SubCategoryController extends Controller {

    public function index() {
      //get root categories
      $categories = Category::whereNull('category_id')->get();
      return view('admin.category.show_subcategories', compact('categories'));
    }



    public function create() {
      $categories = Category::whereNull('category_id')->get();
      return view('admin.category.subcategory_create_form', compact('categories'));
    }



    public function store(Request $request) {
      // validate
      $data = $request->validate([
          'category_id' => 'required|digits_between:1,10|exists:categories,id',
          'sub_category_name' => 'required|max:191',
          'sub_category_slug' => 'required|max:191|regex:/^\S*$/u|unique:categories,slug',
          'meta_title' => 'nullable|max:191',
          'meta_desc' => 'nullable|max:1000',
          'status' => 'required|integer|between:0,1'
      ]);

      if (SubCategoryHelper::storeSubCategory($data))
      return redirect()->back()->withSuccess($data['sub_category_name'] . " has been created.");

      // if failed to delete return err msg.
      return redirect()->back()->withFail("Somthing wrong! can't create subcategory");
    }



    public function show($id) {
        //
    }



    public function edit($id) {
      $sub_category = Category::whereNotNull('category_id')->findOrFail($id);
      $categories = Category::whereNull('category_id')->get();

      return view('admin.category.subcategory_edit_form', compact('categories', 'sub_category'));
    }



    public function update(Request $request, $id) {
      // validate form
      $data = $request->validate([
          'category_id' => 'required|digits_between:1,10|exists:categories,id',
          'sub_category_name' => 'required|max:191',
          'sub_category_slug' => 'required|max:191|regex:/^\S*$/u|unique:categories,slug',
          'meta_title' => 'nullable|max:191',
          'meta_desc' => 'required|max:1000',
          'status' => 'required|integer|between:0,1'
      ]);

      // update category
      if (SubCategoryHelper::updateSubCategory($data, $id))
        return redirect()->back()->withSuccess($data['sub_category_name'] . " has been Updated.");

      // if failed to update return err msg.
      return redirect()->back()->withFail("Somthing wrong! can't update subcategory");
    }



    public function destroy($id) {
      // delete the sub category and it's all childes.
      if (SubCategoryHelper::destroySubCategory($id))
        return redirect()->back()->withSuccess("SubCategory & it's childs has been deleted.");

      // if failed to delete return err msg.
      return redirect()->back()->withFail("Somthing wrong! can't delete SubCategory");
    }
}

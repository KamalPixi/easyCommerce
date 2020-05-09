<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\AppModels\Category;
use Illuminate\Support\Str;
use App\HelperClasses\CategoryHelper;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $categories = Category::whereNull('category_id')->get();
        return view('admin.category.show_categories', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('admin.category.category_create_form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
      $data = $request->validate([
          'category_name' => 'required|max:191',
          'category_slug' => 'required|max:191|regex:/^\S*$/u|unique:categories,slug',
          'meta_title' => 'nullable|max:191',
          'meta_desc' => 'nullable|max:1000',
          'active_category' => 'required|integer|between:0,1'
      ]);

      if (CategoryHelper::storeCategory($data))
        return redirect()->back()->withSuccess($data['category_name'] . " has been created.");

      // if failed to delete return err msg.
      return redirect()->back()->withFail("Somthing wrong! can't create category");
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return 'show'.$id;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $category = Category::whereNull('category_id')->findOrFail($id);
        return view('admin.category.category_edit_form', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
      $data = $request->validate([
          'category_name' => 'required|max:191',
          'category_slug' => 'required|max:191|regex:/^\S*$/u|unique:categories,slug',
          'meta_title' => 'nullable|max:191',
          'meta_desc' => 'nullable|max:1000',
          'active_category' => 'required|integer|between:0,1'
      ]);

      // update category
      if (CategoryHelper::updateCategory($data, $id))
        return redirect()->back()->withSuccess($data['category_name'] . " has been Updated.");

      // if failed to update return err msg.
      return redirect()->back()->withFail("Somthing wrong! can't update category");
    }



    public function destroy($id){
      // delete the category and it's all childes.
      if (CategoryHelper::destroyCategory($id))
        return redirect()->back()->withSuccess("Category & it's childs has been deleted.");

      // if failed to delete return err msg.
      return redirect()->back()->withFail("Somthing wrong! can't delete category");
    }
}

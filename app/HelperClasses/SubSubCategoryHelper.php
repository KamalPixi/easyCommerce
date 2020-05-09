<?php

namespace App\HelperClasses;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\AppModels\Category;


class SubSubCategoryHelper {

  // update category
  public static function updateSubSubCategory($data, $id) {
    //update sub-category
    $category = Category::whereNotNull('category_id')->findOrFail($id);
    $category->name = $data['sub_subcategory_name'];
    $category->category_id = $data['subcategory_id'];
    $category->slug = $data['sub_subcategory_slug'];
    $category->meta_title = $data['meta_title'];
    $category->meta_description = $data['meta_desc'];
    $category->is_active = (bool) $data['status'];

    return $category->save();
  }


  public static function storeSubSubCategory($data) {
    //create sub-subcategory
    $category = new Category();
    $category->category_id = $data['subcategory_id'];
    $category->name = $data['sub_subcategory_name'];
    $category->slug = $data['sub_subcategory_slug'];
    $category->meta_title = $data['meta_title'];
    $category->meta_description = $data['meta_desc'];
    $category->is_active = $data['status'];

    return $category->save();
  }


}

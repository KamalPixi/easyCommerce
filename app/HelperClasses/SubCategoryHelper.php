<?php

namespace App\HelperClasses;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\AppModels\Category;


class SubCategoryHelper {

  // dettroy a category by id & it's all childes.
  public static function destroySubCategory($id) {
    $sub_category = Category::whereNotNull('category_id')->findOrFail($id);

    // delete sub-sub-categories
    $sub_categories = $sub_category->categories;
    foreach ($sub_categories as $sub_category_2) {
       $sub_category_2->delete();
    }

    //delete subcategory
    return $sub_category->delete();
  }


  // update category
  public static function updateSubCategory($data, $id) {
    //update sub-category
    $category = Category::whereNotNull('category_id')->findOrFail($id);
    $category->category_id = $data['category_id'];
    $category->name = $data['sub_category_name'];
    $category->slug = $data['sub_category_slug'];
    $category->meta_title = $data['meta_title'];
    $category->meta_description = $data['meta_desc'];
    $category->is_active = (bool) $data['status'];

    return $category->save();
  }


  public static function storeSubCategory($data) {
    //create sub-category
    $category = new Category();
    $category->category_id = $data['category_id'];
    $category->name = $data['sub_category_name'];
    $category->slug = $data['sub_category_slug'];
    $category->meta_title = $data['meta_title'];
    $category->meta_description = $data['meta_desc'];
    $category->is_active = (bool) $data['status'];

    return $category->save();
  }


}

<?php

namespace App\HelperClasses;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\AppModels\Category;


class CategoryHelper {

  // dettroy a category by id & it's all childes.
  public static function destroyCategory($id) {
    $category = Category::whereNull('category_id')->findOrFail($id);

    // delete sub-sub-categories
    $sub_categories = $category->categories;
    foreach ($sub_categories as $sub_category) {
       $sub_sub_categories = $sub_category->categories;
       foreach ($sub_sub_categories as $sub_sub_category) {
            $sub_sub_category->delete();
       }
    }

    // delete sub-categories
    $sub_categories = $category->categories;
    foreach ($sub_categories as $sub_category) {
       $sub_category->delete();
    }

    //delete category, Parant
    return $category->delete();
  }


  // update category
  public static function updateCategory($data, $id) {
    $category = Category::findOrFail($id);
    $category->name = $data['category_name'];
    $category->slug = $data['category_slug'];
    $category->meta_title = $data['meta_title'];
    $category->meta_description = $data['meta_desc'];
    $category->is_active = (bool) $data['active_category'];

    return $category->save();
  }


  public static function storeCategory($data) {
    $category = new Category();
    $category->name = $data['category_name'];
    $category->slug = $data['category_slug'];
    $category->meta_title = $data['meta_title'];
    $category->meta_description = $data['meta_desc'];
    $category->is_active = (bool) $data['active_category'];

    return $category->save();
  }


}

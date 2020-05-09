<?php

namespace App\AppModels;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // returns subcategories lv 2 childs
    public function categories(){
        return $this->hasMany(Category::class);
    }

    // returns sub-subcategories lvl 3 childs
    public function childrenCategories(){
        return $this->hasMany(Category::class)->with('categories');
    }

    public function parentCategory(){
        return $this->belongsTo(Category::class, 'category_id');
    }

}

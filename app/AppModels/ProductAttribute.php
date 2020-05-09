<?php

namespace App\AppModels;

use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model {

  public function values() {
    return $this->hasMany('App\AppModels\ProductAttributeValue');
  }

}

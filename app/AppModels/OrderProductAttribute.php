<?php

namespace App\AppModels;

use Illuminate\Database\Eloquent\Model;

class OrderProductAttribute extends Model
{
  public function productAttribute() {
    return $this->belongsTo('App\AppModels\ProductAttribute');
  }
  public function productAttributeValue() {
    return $this->belongsTo('App\AppModels\ProductAttributeValue');
  }
}

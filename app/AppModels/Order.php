<?php

namespace App\AppModels;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function product() {
      return $this->belongsTo('App\AppModels\Product');
    }

    public function orderProductAttributes() {
      return $this->hasMany('App\AppModels\OrderProductAttribute');
    }


    public function priceAfterDiscount() {
      if ($this->has_discount == 1) {
        if ($this->discount_type == 'fixed') {
          return $this->unit_sale_price - $this->discount_fixed_price;
        }elseif ($this->discount_type == 'percent') {
          return $this->unit_sale_price - $this->getPriceFromPercentage($this->unit_sale_price, $this->discount_percent);
        }
      }

      return $this->sale_price;
    }


    private function getPriceFromPercentage($price, $percent){
      if ($percent > 0) return round($price/100*$percent, 2);
      else return 0;
    }


}

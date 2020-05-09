<?php

namespace App\AppModels;

use Illuminate\Database\Eloquent\Model;
use App\AppModels\Category;
use App\AppModels\Review;
use App\AppModels\Order;

class Product extends Model {

    public function images() {
      return $this->hasMany('App\AppModels\ProductImage');
    }

    public function attributes() {
      return $this->hasMany('App\AppModels\ProductAttribute');
    }

    public function thumbnail() {
      return $this->hasOne('App\AppModels\ProductImageThumbnail');
    }

    public function brand() {
      return $this->belongsTo('App\AppModels\Brand');
    }

    public function category() {
      return $this->belongsTo('App\AppModels\Category');
    }

    public function subCategory($id) {
      return Category::where('category_id', $id)->first();
    }

    public function subSubCategory($id) {
      return Category::where('category_id', $id)->first();
    }

    public function rating() {
      return Review::where('product_id', $this->id)->avg('rating');
    }
    public function totalRating() {
      return $this->hasMany('App\AppModels\Review')->count();
    }

    public function priceExploder() {
      return explode(".", strval(number_format($this->sale_price, 2)));
    }

    public function totalSold() {
      return $this->hasMany('App\AppModels\Order')->count();
    }



    public function calculate($num1, $op, $num2){
        $result = 0;

        switch ($op) {
            case '+':
                $result = $num1 + $num2;
                break;
            case '-':
                $result = $num1 - $num2;
                break;
            case '/':
                if ($num1 < 0 || $num2 < 0) {
                    $result = 0;
                }else {
                    $result = $num1 / $num2;
                }

                break;
            case '*':
                $result = $num1 * $num2;
                break;

            default:
                $result = 0;
                break;
        }

        return $result;
    }


    public function priceAfterDiscount() {
      if ($this->has_discount == 1) {
        if ($this->discount_type == 'fixed') {
          return $this->sale_price - $this->discount_fixed_price;
        }elseif ($this->discount_type == 'percent') {
          return $this->sale_price - $this->getPriceFromPercentage($this->sale_price, $this->discount_percent);
        }
      }

      return $this->sale_price;
    }


    private function getPriceFromPercentage($price, $percent){
      if ($percent > 0) return round($price/100*$percent, 2);
      else return 0;
    }

}

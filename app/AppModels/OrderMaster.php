<?php

namespace App\AppModels;

use Illuminate\Database\Eloquent\Model;

class OrderMaster extends Model
{
    public function user() {
      return $this->belongsTo('App\UserModels\User');
    }
    public function shippingMethod() {
      return $this->belongsTo('App\AppModels\ShippingMethod');
    }

    public function shippingAddress() {
      return Address::find($this->shpping_address_id);
    }

    public function billingAddress() {
      return Address::find($this->billing_address_id);
    }

    public function orders() {
      return $this->hasMany('App\AppModels\Order');
    }


}

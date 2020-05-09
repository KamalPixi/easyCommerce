<?php

namespace App\UserModels;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\AppModels\OrderMaster;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name','last_name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function hasBoughtThisProduct($product_id) {
      $found = false;
      $order_masters = OrderMaster::where('user_id', auth()->user()->id)->get();
      foreach ($order_masters as $key => $order_master) {
        $orders = $order_master->orders;
        foreach ($orders as $key => $order) {
          if ($order->product_id == $product_id) {
            $found = true;
            break;
          }
        }
        if ($found) break;
      }
      return $found;
    }


}

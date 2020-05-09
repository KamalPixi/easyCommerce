<?php

namespace App\AppModels;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    public function user() {
      return $this->belongsTo('App\UserModels\User');
    }
}

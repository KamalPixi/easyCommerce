<?php

namespace App\AppModels;

use Illuminate\Database\Eloquent\Model;

class Social extends Model
{
  protected $fillable = [
      'name','icon_class', 'address', 'is_active',
  ];
}

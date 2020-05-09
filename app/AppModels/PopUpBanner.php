<?php

namespace App\AppModels;

use Illuminate\Database\Eloquent\Model;

class PopUpBanner extends Model
{
    protected $table = "popup_banners";
    protected $fillable = ['show_on_page', 'call_to_action', 'title', 'description', 'image', 'publish'];
}

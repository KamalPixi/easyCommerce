<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AppModels\Category;
use App\AdminModels\Admin;
use App\AppModels\Product;
use App\Notifications\AdminPasswordReset;
use Illuminate\Support\Facades\Storage;

class TestController extends Controller
{
    public function test(Request $request) {
      return sha1(time());
    }

    public function testPost(Request $request) {
      Storage::put('public/test.txt', $request->name);
      return ['name'=>'the name'];
    }
}

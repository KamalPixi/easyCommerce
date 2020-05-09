<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserApiController extends Controller
{
    public function userDetails(Request $request) {
      // by default it uses user guard
      if ($request->login_status_check) {
        if (Auth::guard('web')->check()) {
          return ['message'=> true];
        }else {
          return ['message'=> false];
        }
      }

    }
}

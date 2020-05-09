<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\MessageBag;

class AdminLoginController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        //$this->middleware('guest:admin')->except('logout');
    }

    /* show admin login form */
    public function showLoginForm(){

        // if already logged in, redirect to dashboard
        if (Auth::guard('admin')->check()) {
            return redirect(route('admin.dashboard'));
        }

        // return login page
        return view('auth.admin_login');
    }


    /* Handle Admin Login */
    public function login(Request $request){
        //validate post data
        $validatedData = $request->validate([
            'email' => 'required|email',
            'password' => 'required|max:255',
        ]);

        // for remembering admin
        $remember = false;
        if ($request->remember) {
            $remember = true;
        }

        // login
        if (Auth::guard('admin')->attempt(['email' => $validatedData['email'], 'password' => $validatedData['password']], $remember)) {
            // Authentication passed...
            return redirect(route('admin.dashboard'));
        }else {
            $errors = new MessageBag(['admin-login-error' => ['Email or Password is invalid.']]);
            return redirect()->back()->withErrors($errors);
        }
    }


    /*
     * Logout admin & redirect admin login page
     */
    public function logout(){
        Auth::guard('admin')->logout();
        return redirect('admin');
    }

    public function showResetForm() {
      return view('auth.passwords.admin_email');
    }

    public function reset() {
      // code...
    }
}

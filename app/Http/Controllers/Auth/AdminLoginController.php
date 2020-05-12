<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\MessageBag;
use Illuminate\Foundation\Auth\ThrottlesLogins;

class AdminLoginController extends Controller
{

    use ThrottlesLogins;
    public $maxAttempts = 5;
    public $decayMinutes = 5;

    public function __construct(){
        //$this->middleware('guest:admin')->except('logout');
    }

    // for ThrottlesLogins
    public function username(){
      return 'email';
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


        //check if the user has too many login attempts.
        if ($this->hasTooManyLoginAttempts($request)){
            //Fire the lockout event.
            $this->fireLockoutEvent($request);

            //redirect the user back after lockout.
            return $this->sendLockoutResponse($request);
        }

        // for remembering admin
        $remember = false;
        if ($request->remember) {
            $remember = true;
        }

        // login
        if (Auth::guard('admin')->attempt(['email' => $validatedData['email'], 'password' => $validatedData['password']], $remember)) {
            // Authentication passed...
            return redirect(route('admin.dashboard'));
        }


        //keep track of login attempts from the user.
        $this->incrementLoginAttempts($request);

        $errors = new MessageBag(['admin-login-error' => ['Email or Password is invalid.']]);
        return redirect()->back()->withErrors($errors);

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

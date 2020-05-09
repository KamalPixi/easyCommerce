<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\AdminModels\Admin;
use App\UserModels\User;
use App\AppModels\Product;
use App\AppModels\OrderMaster;

class AdminController extends Controller
{
    // show admin dashboard
    public function index(){
        $totals = [
          'total_customers' => 0,
          'total_products_available' => 0,
          'total_pending_orders' => 0,
          'total_completed_orders' => 0,
          'total_shipped_orders' => 0
        ];

        // count totals
        $totals['total_customers'] = User::count();
        $totals['total_products_available'] = Product::where('stock', '>', 0)->count();
        $totals['total_pending_orders'] = OrderMaster::where('status', 'pending')->count();
        $totals['total_completed_orders'] = OrderMaster::where('status', 'completed')->count();
        $totals['total_shipped_orders'] = OrderMaster::where('status', 'shipped')->count();

        return view('admin.dashboard', compact('totals'));
    }


    // show profile, password update form, based on request 'for' parameter
    public function profile(Request $request) {
      switch ($request->for) {

        // show prodile page
        case 'profile':
          $user = auth()->guard('admin')->user();
          return view('admin.profile.profile_edit_form', compact('user'));
          break;

          // show password change form
          case 'password_change':
            return view('admin.profile.password_change_form');
            break;

        default:
          return redirect()->route('admin.dashboard');
          break;
      }

    }


    // update profile, password update form, based on request 'for' parameter
    public function profileUpdate(Request $request) {
      switch ($request->for) {

        // update admin profile
        case 'profile_update':
          return $this->updateUserProfile($request);
          break;

        // change admin password
        case 'password_change':
          return $this->updateUserPassword($request);
          break;

        default:
          return redirect()->route('admin.dashboard');
          break;
      }
    }



    private function updateUserProfile($request) {
      $d = $request->validate([
        'first_name' => 'required|max:191',
        'last_name' => 'nullable|max:191',
        'email' => 'required|max:191|email',
        'mobile' => 'nullable|max:15',
        'image' => 'nullable|image|mimes:png,jpeg,jpg|max:20000',
      ]);

      // if this email already exits
      if (auth()->guard('admin')->user()->email != $d['email']) {
        if (Admin::where('email', $d['email'])->exists()) {
          return redirect()->back()->withFail('This email already taken!');
        }
      }

      // if there is image upload
      $path = "";
      if ($request->hasFile('image')) {
        $path = $request->file('image')->storeAs('public/user_images', 'admin_img_'.mt_rand().'_.'.$request->file('image')->extension());
      }

      $a = Admin::findOrFail(auth()->guard('admin')->user()->id);
      $a->first_name = $d['first_name'];
      $a->last_name = $d['last_name'];
      $a->email = $d['email'];
      $a->mobile = $d['mobile'];
      $a->image = basename($path);
      if ($a->save())
        return redirect()->back()->withSuccess('Profile has been updated');
      return redirect()->back()->withFail('Somthing Wrong!');
    }




    private function updateUserPassword($request) {
      $d = $request->validate([
        'current_password' => 'required|max:191',
        'password' => 'required|max:191|confirmed'
      ]);

      $a = Admin::findOrFail(auth()->guard('admin')->user()->id);
      // compare hash
      if (Hash::check($d['current_password'], $a->password)) {
        $a->password = bcrypt($d['password']);
      }else {
        return redirect()->back()->withFail('Wrong password!');
      }

      if ($a->save())
        return redirect()->back()->withSuccess('Password has been changed');
      return redirect()->back()->withFail('Somthing Wrong!');
    }

}

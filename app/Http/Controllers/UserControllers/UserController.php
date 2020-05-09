<?php

namespace App\Http\Controllers\UserControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\AppModels\OrderMaster;
use App\AppModels\Review;
use App\UserModels\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }



    public function index(Request $request) {
        // get user orders
        $order_masters;
        $user = auth()->guard('web')->user();
        switch ($request->for) {
          case 'shipped':
            $order_masters = OrderMaster::where('user_id', $user->id)->where('status', 'shipped')->get();
            break;
          case 'completed':
            $order_masters = OrderMaster::where('user_id', $user->id)->where('status', 'completed')->get();
            break;

          case 'logout':
            Auth::logout();
            return redirect()->route('index');
            break;

          default:
            $order_masters = OrderMaster::where('user_id', $user->id)->get();
            break;
        }

        // return user dashboard
        return view('app.user.user_dashboard', compact('order_masters', 'user'));
    }



    // show create form
    public function create(Request $request) {
      // get user
      $user = auth()->guard('web')->user();

      switch ($request->for) {
        case 'profile':
          return view('app.user.profile', compact('user'));
          break;

        case 'address':
          return view('app.user.address', compact('user'));
          break;

        case 'password':
          return view('app.user.password', compact('user'));
          break;

        default:
          break;
      }
    }



    public function store(Request $request) {

      switch ($request->for) {
        case 'profile':
          return $this->storeProfile($request);
          break;

        case 'password':
          return $this->changePassword($request);
          break;

        // store review
        case 'review':
          return $this->storeReview($request);
          break;

        default:
          break;
      }

    }



    public function show($id) {

    }



    public function edit($id) {
      $user = auth()->guard('web')->user();
      return view('app.user.profile');
    }



    public function update(Request $request, $id) {


    }



    public function destroy($id) {

    }


    private function storeProfile($request) {
      $d = $request->validate([
        'first_name' => 'required|max:191',
        'last_name' => 'required|max:191',
        'email' => 'required|max:191',
        'mobile' => 'nullable|max:12',
        'image' => 'nullable|image|mimes:png,jpeg,jpg|max:10000'
      ]);

      // get current user
      $user = auth()->guard('web')->user();
      $user_r = User::findOrFail($user->id);
      $user_r->first_name = $d['first_name'];
      $user_r->last_name = $d['last_name'];
      $user_r->mobile = $d['mobile'];
      // validate email
      if ($user->email != $d['email']) {
        if (User::where('email', $d['email'])->exists())
          return redirect()->back()->withFail('Email already exists.');
        $user_r->email = $d['email'];
      }

      // store image if provided
      if ($request->hasFile('image')) {
        // store image
        $path = $request->file('image')->storeAs(
            'public/user_images',
            'user_img_'.$user->id.'_'.mt_rand().$request->file('image')->extension()
        );
        $user_r->image = basename($path);
      }

      // return success or fail msg
      if ($user_r->save()) return redirect()->back()->withSuccess('Profile has been updated.');
      else return redirect()->back()->withFail('Something wrong.');
    }



    private function changePassword($request) {
      $d = $request->validate([
        'current_password' => 'required|min:8|max:191',
        'new_password' => 'required|min:8|max:191',
        'repeat_new_password' => 'required|min:8|max:191'
      ]);

      $user_r = User::findOrFail(auth()->guard('web')->user()->id);
      if (!Hash::check($d['current_password'], $user_r->password))
        return redirect()->back()->withFail('Wrong password.');
      if ($d['new_password'] != $d['repeat_new_password'])
        return redirect()->back()->withFail('Password does not match.');
      $user_r->password = Hash::make($d['new_password']);

      // return success or fail msg
      if ($user_r->save()) return redirect()->back()->withSuccess('Password has been changed.');
      else return redirect()->back()->withFail('Something wrong.');
    }


    // store review
    public function storeReview($request) {
      $d = $request->validate([
        'product_id' => 'bail|required|max:10|exists:products,id',
        'rating' => 'required|numeric|min:1|max:5',
        'review' => 'nullable|max:20000'
      ]);

      $r = new Review();
      $r->user_id = auth()->user()->id;
      $r->product_id = $d['product_id'];
      $r->rating = $d['rating'];
      $r->review = $d['review'];

      // return success or fail msg
      if ($r->save()) return redirect()->back()->withSuccess('Review received.');
      else return redirect()->back()->withFail('Something wrong.');

    }


}

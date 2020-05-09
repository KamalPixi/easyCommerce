<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\AppModels\OrderMaster;
use App\AppModels\Slider;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller {

    // show
    public function index() {
      $sliders = Slider::paginate(15);
      return view('admin.products.sliders', compact('sliders'));
    }

    // show create form
    public function create() {
      return view('admin.products.slider_create_form');
    }


    // create
    public function store(Request $request) {
      $d = $request->validate([
        'title' => 'nullable|max:191',
        'sub_title' => 'nullable|max:191',
        'link' => 'nullable|max:500',
        'is_active' => 'required|max:1',
        'image' => 'required|image|mimes:png,jpeg,jpg|max:10000',
        'video' => 'nullable|mimes:mp4,mov,avi,wmv|max:50000',
      ]);
      $s = new Slider();
      $s->title = $d['title'];
      $s->subtitle = $d['sub_title'];
      $s->link = $d['link'];
      $s->is_active = $d['is_active'];
      $path = $request->file('image')->storeAs(
          'public/product_images',
          'slider_img_'.mt_rand().'.'.$request->file('image')->extension()
      );
      $s->image = basename($path);
      if ($request->hasFile('video')) {
        $path = $request->file('video')->storeAs(
            'public/media',
            'slider_video_'.mt_rand().'.'.$request->file('video')->extension()
        );
        $s->video = basename($path);
      }

      if ($s->save()) return redirect()->back()->withSuccess('Slider has been created.');
      return redirect()->back()->withFail('Someting wrong!');
    }


    // show
    public function show($id) {
        //
    }



    // show edit form
    public function edit($id) {
      $slider = Slider::findOrFail($id);
      return view('admin.products.slider_edit_form', compact('slider'));
    }



    // update
    public function update(Request $request, $id) {
      $d = $request->validate([
        'title' => 'nullable|max:191',
        'sub_title' => 'nullable|max:191',
        'link' => 'nullable|max:500',
        'is_active' => 'required|max:1',
        'image' => 'nullable|image|mimes:png,jpeg,jpg|max:10000',
      ]);
      $s = Slider::findOrFail($id);
      $s->title = $d['title'];
      $s->subtitle = $d['sub_title'];
      $s->link = $d['link'];
      $s->is_active = $d['is_active'];
      // update image if uploaded
      if ($request->hasFile('image')) {
        $path = $request->file('image')->storeAs(
            'public/product_images',
            'slider_img_'.mt_rand().'.'.$request->file('image')->extension()
        );
        // delete image
        Storage::disk('public')->delete('product_images/'.$s->image);
        $s->image = basename($path);
      }

      if ($request->hasFile('video')) {
        $path = $request->file('video')->storeAs(
            'public/media',
            'slider_video_'.mt_rand().'.'.$request->file('video')->extension()
        );
        // delete image
        Storage::disk('public')->delete('media/'.$s->video);
        $s->video = basename($path);
      }

      if ($s->save()) return redirect()->back()->withSuccess('Slider has been updated.');
      return redirect()->back()->withFail('Someting wrong!');
    }


    // delete
    public function destroy($id) {
      $s = Slider::findOrFail($id);
      // delete image
      Storage::disk('public')->delete('product_images/'.$s->image);
      Storage::disk('public')->delete('media/'.$s->video);
      if ($s->delete()) return redirect()->back()->withSuccess('Slider has been deleted.');
      return redirect()->back()->withFail('Someting wrong!');
    }

}

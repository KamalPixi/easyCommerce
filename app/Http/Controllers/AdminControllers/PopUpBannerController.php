<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\AppModels\PopUpBanner;

class PopUpBannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $popup_banners = PopUpBanner::all();
        return view('admin.popup_banners.popup_banners', compact('popup_banners'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.popup_banners.popup_banner_create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $d = $request->validate([
          'show_on_page' => 'required|max:191',
          'call_to_action' => 'nullable|max:191',
          'title' => 'nullable|max:191',
          'description' => 'nullable|max:191',
          'image' => 'nullable|image|mimes:png,jpeg,jpg|max:10000',
          'publish' => 'required|numeric|min:0|max:1',
        ]);

        // store image
        if ($request->hasFile('image')) {
          $path = $request->file('image')->storeAs('public/media','banner_image_'.mt_rand().'_.'.$request->file('image')->extension());
          $d['image'] = basename($path);
        }

        if (PopUpBanner::create($d))
          return redirect()->back()->withSuccess('Banner has been created.');
        return redirect()->back()->withFail('Something wrong!');

    }










    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $popup_banner = PopUpBanner::findOrFail($id);
        return view('admin.popup_banners.popup_banner_edit', compact('popup_banner'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $d = $request->validate([
        'show_on_page' => 'required|max:191',
        'call_to_action' => 'nullable|max:191',
        'title' => 'nullable|max:191',
        'description' => 'nullable|max:191',
        'image' => 'nullable|image|mimes:png,jpeg,jpg|max:10000',
        'publish' => 'required|numeric|min:0|max:1',
      ]);

      $p = PopUpBanner::findOrFail($id);

      // store image
      if ($request->hasFile('image')) {
        $path = $request->file('image')->storeAs('public/media','banner_image_'.mt_rand().'_.'.$request->file('image')->extension());
        $d['image'] = basename($path);
      }

      if ($p->update($d))
        return redirect()->back()->withSuccess('Banner has been updated.');
      return redirect()->back()->withFail('Something wrong!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $p = PopUpBanner::findOrFail($id);
        if ($p->delete())
          return redirect()->back()->withSuccess('Banner has been deleted.');
        return redirect()->back()->withFail('Something wrong!');
    }
}

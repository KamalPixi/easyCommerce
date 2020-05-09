<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\AppModels\WebsiteSetting;

class WebsiteSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $website_setting = WebsiteSetting::first();
        return view('admin.website_settings.edit', compact('website_setting'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        'name' => 'nullable|max:191',
        'email' => 'nullable|max:191|email',
        'mobile' => 'nullable|max:50',
        'about' => 'nullable|max:2000',
        'logo' => 'nullable|image|mimes:png,jpg,jpeg|max:10000'
      ]);

      // get setting if already exists to modify
      $w = WebsiteSetting::first();

      // store image
      $path = '';
      if ($request->hasFile('logo')) {
        $path = $request->file('logo')->storeAs('public/media', 'logo.'.$request->file('logo')->extension());
      }

      if ($w) {
        $w->name = $d['name'];
        $w->email = $d['email'];
        $w->mobile = $d['mobile'];
        $w->about = $d['about'];
        $w->logo = basename($path);
        if ($w->save())
          return redirect()->back()->withSuccess('Settings has been Updated.');
        return redirect()->back()->withFail('Somthing wrong!');
      }

      $ws = new WebsiteSetting();
      $ws->name = $d['name'];
      $ws->email = $d['email'];
      $ws->mobile = $d['mobile'];
      $ws->about = $d['about'];
      $ws->logo = basename($path);
      if ($ws->save())
        return redirect()->back()->withSuccess('Settings has been Stored.');
      return redirect()->back()->withFail('Somthing wrong!');
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

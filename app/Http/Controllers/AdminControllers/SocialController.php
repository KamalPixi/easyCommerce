<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\AppModels\Social;

class SocialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $socials = Social::all();
        return view('admin.socials.show_socials', compact('socials'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.socials.social_create_form');
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
          'icon_class' => 'nullable|max:191',
          'address' => 'required|max:191',
          'is_active' => 'nullable|numeric|min:0|max:1'
        ]);

        if (Social::create($d))
          return redirect()->back()->withSuccess('Social details Has been saved.');
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
        $social = Social::findOrFail($id);
        return view('admin.socials.social_edit_form', compact('social'));
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
        'name' => 'nullable|max:191',
        'icon_class' => 'nullable|max:191',
        'address' => 'required|max:191',
        'is_active' => 'nullable|numeric|min:0|max:1'
      ]);

      $social = Social::findOrFail($id);

      if ($social->update($d))
        return redirect()->back()->withSuccess('Social details Has been updated.');
      return redirect()->back()->withFail('Somthing wrong!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $s = Social::findOrFail($id);
        if ($s->delete())
          return redirect()->back()->withSuccess('Delete success');
        return redirect()->back()->withFail('Somthing Wrong!');
    }
}

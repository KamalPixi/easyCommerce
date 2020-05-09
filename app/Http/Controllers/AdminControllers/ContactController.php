<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\AppModels\Contact;

class ContactController extends Controller
{
    public function index() {
        $contacts = Contact::paginate(15);
        return view('admin.contacts.contacts', compact('contacts'));
    }

    public function create() {
      return redirect('/');
    }


    public function store(Request $request) {
      return redirect('/');
    }



      public function show($id)
      {
        return redirect('/');
      }



      public function edit($id) {
        return redirect('/');
      }



      public function update(Request $request, $id) {
        return redirect('/');
      }



      public function destroy($id){
        $c = Contact::findOrFail($id);
        if ($c->delete())
          return redirect()->back()->withSuccess('Delete success');
        return redirect()->back()->withFail('Delete Failed!');
      }
}

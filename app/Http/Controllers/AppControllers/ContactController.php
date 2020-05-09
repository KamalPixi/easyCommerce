<?php

namespace App\Http\Controllers\AppControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\AppModels\Contact;

class ContactController extends Controller {

    public function index() {
      return view('app.pages.contact');
    }



    public function create() {
      return redirect('/');
    }



    public function store(Request $request) {
      $data = $request->validate([
          'message' => 'required|max:3000',
          'name' => 'nullable|max:250',
          'email' => 'required|email|max:250',
          'subject' => 'nullable|max:255'
      ]);

      $contact = new Contact();
      $contact->message = $data['message'];
      $contact->name = $data['name'];
      $contact->email = $data['email'];
      $contact->subject = $data['subject'];

      if ($contact->save()) {
          return redirect()->back()->withSuccess("Thank You for contacting, We will contact you soon.");
      }

      return redirect()->back()->withFail("Failed!.");
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
      return redirect('/');
    }

}

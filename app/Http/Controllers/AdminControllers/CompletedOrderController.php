<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\AppModels\OrderMaster;

class CompletedOrderController extends Controller {

    // show brands
    public function index() {
      $completed_orders = OrderMaster::where('status', 'completed')->paginate(15);
      return view('admin.orders.completed', compact('completed_orders'));
    }

    // show brand create form
    public function create() {

    }


    // create a brand
    public function store(Request $request) {

    }


    public function show($id) {
        //
    }



    // show brand edit form
    public function edit($id) {

    }



    // update brand
    public function update(Request $request, $id) {

    }


    // delete barnd
    public function destroy($id) {

    }

}

<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\AppModels\OrderMaster;

class OrderMasterController extends Controller {

    // show
    public function index() {
      return 'index';
    }

    // show create form
    public function create() {

    }


    // create
    public function store(Request $request) {

    }


    public function show($id) {
        // get order
        $order_master = OrderMaster::findOrFail($id);
        $order_master->is_new = 0;
        $order_master->save();

        // return order view
        return view('admin.orders.order_master_show', compact('order_master'));
    }



    // show edit form
    public function edit($id) {

    }



    // update
    public function update(Request $request, $id) {


      switch ($request->for) {
        case 'mark_as_shipped':
          $om = OrderMaster::findOrFail($id);
          $om->status = 'shipped';
          $om->save();
          return redirect()->back()->withSuccess('Order has been shipped.');
          break;

        case 'mark_as_completed':
          $om = OrderMaster::findOrFail($id);
          $om->status = 'completed';
          $om->save();
          return redirect()->back()->withSuccess('Order has been completed.');
          break;

        default:
          // code...
          break;
      }


    }


    // delete
    public function destroy($id) {
      return 'destroy';
    }

}

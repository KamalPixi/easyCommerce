@extends('admin.app')
  @section('content')

    <!-- error message display -->
    @if($errors->any())
        @foreach($errors->all() as $error)
            @include('admin.parts.flash', $flash_msg = ['class' => 'alert-danger','title' => 'Error!','msg' => $error])
        @endforeach
    @endif

    @if(Session::has('success'))
      @include('admin.parts.flash', $flash_msg = ['class' => 'alert-success','title' => 'Success','msg' => Session::get('success')])
    @endif

    @if(Session::has('fail'))
      @include('admin.parts.flash', $flash_msg = ['class' => 'alert-danger','title' => 'Error!','msg' => Session::get('fail')])
    @endif
    <!-- end error msg -->


  <div class="wrapper">
    @include('admin.includes.nav')
    @include('admin.includes.aside')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

      <!--breadcrumb-->
      @include('admin.includes.breadcrumb')

      <div class="container-fluid">
      <!-- ### content goes here ####-->


      @if(isset($order_master))

      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">

              <!-- Main content -->
              <div class="invoice p-3 mb-3">
                <!-- title row -->
                <div class="row">
                  <div class="col-12">
                    <h4>
                      <i class="fas fa-user"></i> User : {{ $order_master->user->first_name.' '.$order_master->user->last_name ?? '' }}
                      <small class="float-right">Date & Time: {{ $order_master->created_at ?? '' }}</small>
                    </h4>
                  </div>
                  <!-- /.col -->
                </div>
                <!-- info row -->
                <div class="row invoice-info">
                  <div class="col-sm-4 invoice-col">
                    <h6> Billing Address</h6>
                    <address class="d-flex">
                      <div class="">
                        First Name: <br>
                        Last Name: <br>
                        Address 1: <br>
                        Address 2: <br>
                        City : <br>
                        State : <br>
                        Zip : <br>
                        Country: <br>
                        Mobile: <br>
                        Email: <br>
                      </div>
                      <div class="pl-2">
                        {{ $order_master->billingAddress()->first_name ?? '' }} <br>
                        {{ $order_master->billingAddress()->last_name ?? '' }} <br>
                        {{ $order_master->billingAddress()->address_1 ?? '' }} <br>
                        {{ $order_master->billingAddress()->address_2 ?? '' }} <br>
                        {{ $order_master->billingAddress()->city ?? '' }} <br>
                        {{ $order_master->billingAddress()->state ?? '' }} <br>
                        {{ $order_master->billingAddress()->zip ?? '' }} <br>
                        {{ $order_master->billingAddress()->country ?? '' }} <br>
                        <br>
                        <br>
                      </div>
                    </address>
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-4 invoice-col">
                    <h6> Shipping Address</h6>
                    <address class="d-flex">
                      <div class="">
                        First Name: <br>
                        Last Name: <br>
                        Address 1: <br>
                        Address 2: <br>
                        City : <br>
                        State : <br>
                        Zip : <br>
                        Country: <br>
                        Mobile: <br>
                        Email: <br>
                      </div>
                      <div class="pl-2 font-weight-bold">
                        {{ $order_master->shippingAddress()->first_name ?? '' }} <br>
                        {{ $order_master->shippingAddress()->last_name ?? '' }} <br>
                        {{ $order_master->shippingAddress()->address_1 ?? '' }} <br>
                        {{ $order_master->shippingAddress()->address_2 ?? '' }} <br>
                        {{ $order_master->shippingAddress()->city ?? '' }} <br>
                        {{ $order_master->shippingAddress()->state ?? '' }} <br>
                        {{ $order_master->shippingAddress()->zip ?? '' }} <br>
                        {{ $order_master->shippingAddress()->country ?? '' }} <br>
                        {{ $order_master->shippingAddress()->mobile ?? '' }} <br>
                        <br>
                        <br>
                      </div>
                    </address>
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-4 invoice-col">
                    <b>Invoice #{{ $order_master->id ?? ''}}</b><br>
                    <br>
                    <b>Order ID:</b> {{ $order_master->id ?? ''}}<br>
                    <b>Payment Due:</b> 0/00/0000<br>
                    <b>Account:</b> 0.00 <br>
                    <b>Status:</b>
                      <span class="badge badge-@if($order_master->status == 'completed')success @else{{'secondary'}}@endif">{{ $order_master->status ?? '' }}</span>
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->

                <!-- Table row -->
                <div class="row">
                  <div class="col-12 table-responsive">
                    <table class="table table-striped">
                      <thead>
                      <tr>
                        <th>#</th>
                        <th>Pro.Id</th>
                        <th>SKU</th>
                        <th>Name</th>
                        <th>Attributes</th>
                        <th>UnitPrice</th>
                        <th>Qty</th>
                        <th>Discount</th>
                        <th>Sub Total</th>
                      </tr>
                      </thead>
                      <tbody>
                      @php $sub_total = 0; @endphp
                      @foreach($order_master->orders as $k => $order)
                      @php $sub_total += $order->total_sale_price; @endphp

                      <tr>
                        <td> {{ $k+1 ?? '' }} </td>
                        <td> <a target="_blank" href="{{ route('products.edit', $order->product_id) }}">{{ $order->product_id ?? '' }}</a> </td>
                        <td> {{ $order->product->sku ?? '' }} </td>
                        <td> {{ $order->product->title ?? '' }} </td>
                        <td>
                          @foreach($order->orderProductAttributes as $k2 => $order_p_attr)
                            {{ $order_p_attr->productAttribute->key ?? '' }}:
                            {{ $order_p_attr->productAttributeValue->value ?? '' }}
                            <br>
                          @endforeach
                        </td>

                        <td>{{ $order->unit_sale_price ?? '' }}</td>
                        <td>{{ $order->qty ?? '' }}</td>
                        <td>{{ $order->subtotal_price - $order->total_sale_price ?? '' }}</td>
                        <td class="font-weight-bold">{{ $order->total_sale_price ?? '' }}</td>
                      </tr>
                      @endforeach

                      </tbody>
                    </table>
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->

                <div class="row">
                  <!-- accepted payments column -->
                  <div class="col-6">
                    <p class="my-0"><span class="font-weight-bold">Shipping Method:</span> {{ $order_master->shippingMethod->name ?? '' }}</p>
                    <p class="text-muted well well-sm shadow-none">
                      {{ $order_master->shippingMethod->description ?? '' }}
                    </p>

                    <p class="lead">Payment Methods:</p>
                    <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                      Etsy doostang zoodles disqus groupon greplin.
                    </p>
                  </div>
                  <!-- /.col -->
                  <div class="col-6">
                    <p class="lead">Amount Due 2/22/2014</p>

                    <div class="table-responsive">
                      <table class="table">
                        <tr>
                          <th style="width:50%">Subtotal:</th>
                          <td>&#2547; {{ $sub_total ?? '' }}</td>
                        </tr>
                        <tr>
                          <th>Shipping:</th>
                          <td>&#2547; {{ $order_master->shippingMethod->cost ?? '' }}</td>
                        </tr>
                        <tr>
                          <th>Total:</th>
                          <td> <strong>&#2547; {{ $order_master->total_price ?? '' }}</strong></td>
                        </tr>
                      </table>
                    </div>
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->

                <!-- this row will not appear when printing -->
                @if($order_master->status != 'completed')
                <div class="row no-print">
                  <div class="col-12">
                    <a href="invoice-print.html" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>

                    <form action="{{route('order_master.update', $order_master->id)}}" method="post">
                      <input type="hidden" name="for" value="mark_as_completed">
                      @csrf
                      @method('PATCH')
                      <button type="submit" name="completed" class="btn btn-success float-right" style="margin-right: 5px;">
                        <i class="fas fa-check-circle"></i></i> Mark as Completed
                      </button>
                    </form>

                    <form action="{{route('order_master.update', $order_master->id)}}" method="post">
                      <input type="hidden" name="for" value="mark_as_shipped">
                      @csrf
                      @method('PATCH')
                      <button type="submit" @if($order_master->status == 'shipped') disabled @endif name="shipped" class="btn btn-primary float-right" style="margin-right: 5px;">
                        <i class="fas fa-shipping-fast"></i></i> Mark as Shipped
                      </button>
                    </form>
                  </div>
                </div>
                @endif

              </div>
              <!-- /.invoice -->


            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </section>

      @endif
      <!-- /.content -->






    <!--### end content goes here ### -->
    </div>
  <!-- End Main content -->
  </div>
  <!-- /.content-wrapper -->
  @include('admin.includes.footer')
  <!-- /.control-sidebar -->
  @include('admin.includes.side_controll')
  </div>
  <!-- ./wrapper -->

  @endsection('content')

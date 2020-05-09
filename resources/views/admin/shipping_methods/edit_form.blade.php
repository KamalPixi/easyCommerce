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


      <!-- Product Basic -->
      <div class="card card-default">
        <form action="@if(Route::has('shipping-methods.update')) {{ route('shipping-methods.update', $shipping_method->id) }} @endif" method="POST">
          @CSRF
          @method('PATCH')
        <div class="card-header">
          <h3 class="card-title">Edit Shipping</h3>

          <div class="card-tools">
            <a href="{{ route('shipping-methods.index') }}" class="btn btn-sm btn-primary">Back</a>
          </div>
        </div>

        <!-- /.card-header -->
        <div class="card-body" style="display: block;">

          <div class="row">
            <div class="col-md-12">

              <div class="form-group">
                  <label for="name">Name *</label>
                  <input value="{{ $shipping_method->name ?? '' }}" type="text" class="form-control" name="name" id="name">
              </div>

              <div class="form-group">
                  <label for="minimum_amount">Minimum Amount *</label>
                  <input value="{{ $shipping_method->minimum_amount ?? '' }}" type="text" class="form-control" name="minimum_amount" id="brand_name">
              </div>

              <div class="form-group">
                  <label for="description">Description</label>
                  <textarea name="description" class="form-control" rows="2" cols="80">{{ $shipping_method->description ?? '' }}</textarea>
              </div>

              <div class="form-group">
                  <label for="cost">Fee *</label>
                  <input value="{{ $shipping_method->cost ?? '' }}" type="number" class="form-control" name="cost">
              </div>

              <div class="form-group">
                <label for="is_active">Active *</label>
                <select name="is_active" class="custom-select " id="is_active" onchange="productPublishBtnChange(this)">
                  <option @if($shipping_method->is_active) selected @endif value="1">Yes</option>
                    <option @if(!$shipping_method->is_active) selected @endif value="0">No</option>
                </select>
              </div>



            </div>
          </div>
          <!-- /.row -->

        </div>
        <!-- /.card-body -->
        <div class="card-footer" style="display: block;">
          <button type="submit" class="btn btn-primary">Update</button>
        </div>
        </form>
      </div>
      <!-- end Product Basic -->


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

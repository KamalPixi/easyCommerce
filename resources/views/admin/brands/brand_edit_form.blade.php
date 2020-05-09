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
        <form action="@if(Route::has('brands.update')) {{ route('brands.update', $brand->id) }} @endif" method="POST">
          @CSRF
          @method('PATCH')
        <div class="card-header">
          <h3 class="card-title">Edit Brand</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-remove"></i></button>
          </div>
        </div>

        <!-- /.card-header -->
        <div class="card-body" style="display: block;">

          <div class="row">
            <div class="col-md-12">

              <div class="form-group">
                  <label for="brand_name">Brand Name *</label>
                  <input value="{{ $brand->name }}" type="text" class="form-control" name="brand_name" id="brand_name" placeholder="Enter brand name...">
              </div>

            </div>
          </div>
          <!-- /.row -->

        </div>
        <!-- /.card-body -->
        <div class="card-footer" style="display: block;">
          <button type="submit" class="btn btn-primary">Update Brand</button>
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

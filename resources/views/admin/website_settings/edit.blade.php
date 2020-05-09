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
      <!-- Main content -->
      <div class="container-fluid">

      <!-- ### content goes here ####-->

      <!-- Product Basic -->
      <form action="@if(Route::has('website-settings.store')) {{ route('website-settings.store') }} @endif" method="POST" enctype="multipart/form-data">
      @CSRF
      <div class="card card-default">

        <div class="card-header">
          <h3 class="card-title">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
            Store Details
          </h3>
          <div class="card-tools">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-primary">Dashboard</a>
          </div>
        </div>

        <!-- /.card-header -->
        <div class="card-body" style="display: block;">

            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                    <label>Store Name</label>
                    <input type="text" name="name" value="{{ $website_setting->name ?? '' }}" class="form-control">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                    <label>Phone</label>
                    <input type="text" name="mobile" value="{{ $website_setting->mobile ?? '' }}" class="form-control">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" value="{{ $website_setting->email ?? '' }}" class="form-control">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                    <label>About</label>
                    <textarea name="about" class="form-control" rows="8" cols="80">{{ $website_setting->about ?? '' }}</textarea>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                    <label>Logo</label>
                    <input type="file" name="logo" class="form-control">
                    <img src="{{asset('storage/media/') }}{{$website_setting->logo ?? ''}}" alt="">
                </div>
              </div>
            </div>



        </div>
        <!-- /.card-body -->
        <div class="card-footer" style="display: block;">
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
      </div>
      </form>
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

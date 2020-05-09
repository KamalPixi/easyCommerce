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
    @include('admin.includes.aside', ['data'=>'Profile Update'])

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
    <!--breadcrumb-->
    @include('admin.includes.breadcrumb')

    <!-- Main content -->
    <div class="container-fluid">

<!-- Product Basic -->
<form action="@if(Route::has('admin.profile.update')) {{ route('admin.profile.update') }} @endif" method="POST" enctype="multipart/form-data">
  <input type="hidden" name="for" value="profile_update">
  @CSRF

<div class="card card-default">

  <div class="card-header">
    <h3 class="card-title">
      <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
      Update Profile
    </h3>
    <div class="card-tools">
      <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-primary">Back</a>
    </div>
  </div>

  <!-- /.card-header -->
  <div class="card-body" style="display: block;">

      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
              <label>First Name</label>
              <input type="text" name="first_name" value="{{ $user->first_name ?? '' }}" class="form-control">
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
              <label>Last Name</label>
              <input type="text" name="last_name" value="{{ $user->last_name ?? '' }}" class="form-control">
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
              <label>Email</label>
              <input type="text" name="email" value="{{ $user->email ?? '' }}" class="form-control">
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
              <label>Mobile</label>
              <input type="text" name="mobile" value="{{ $user->mobile ?? '' }}" class="form-control">
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
              <label>Image</label>
              <input type="file" name="image" class="form-control">
          </div>
        </div>
      </div>


  </div>
  <!-- /.card-body -->
  <div class="card-footer" style="display: block;">
    <button type="submit" class="btn btn-primary">Update</button>
  </div>
</div>
</form>
<!-- end Product Basic -->


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

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
    @include('admin.includes.aside', ['data'=>'some data'])

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
    <!--breadcrumb-->
    @include('admin.includes.breadcrumb')

    <!-- Main content -->
    <div class="container-fluid">

<!-- Product Basic -->
<form action="@if(Route::has('socials.update')) {{ route('socials.update', $social->id) }} @endif" method="POST">
@CSRF
@method('PATCH')
<div class="card card-default">

  <div class="card-header">
    <h3 class="card-title">
      <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
      Social Link Create Form
    </h3>
    <div class="card-tools">
      <a href="{{ route('socials.index') }}" class="btn btn-sm btn-primary">Back</a>
    </div>
  </div>

  <!-- /.card-header -->
  <div class="card-body" style="display: block;">

      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
              <label>Social Platform Name </label>
              <input type="text" name="name" value="{{ $social->name ?? '' }}" class="form-control">
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
              <label>Icon Class </label>
              <input type="text" name="icon_class" value="{{ $social->icon_class ?? '' }}" class="form-control">
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
              <label>URL * <span style="font-size:.9rem;font-weight:400">(Ex: www.facebook.com)</span></label>
              <input type="text" name="address" value="{{ $social->address ?? '' }}" class="form-control">
          </div>
        </div>
      </div>

    <div class="row">
      <div class="col-md-12">
        <div class="form-group">
            <label>Publish *</label>
            <select class="form-control" name="is_active">
              <option value="1"@if($social->is_active == 1) selected @endif>Publish</option>
              <option value="0"@if($social->is_active == 0) selected @endif>Unpublish</option>
            </select>
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

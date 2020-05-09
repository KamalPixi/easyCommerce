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
<div class="content-wrapper">
<!--breadcrumb-->
@include('admin.includes.breadcrumb')
<div class="container-fluid">


<!-- Product Basic -->
<form action="@if(Route::has('sliders.store')) {{ route('sliders.store') }} @endif" method="POST" enctype="multipart/form-data">
@CSRF
<div class="card card-default">

  <div class="card-header">
    <h3 class="card-title">
      <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
      Slider Create Form
    </h3>
    <div class="card-tools">
      <a href="{{ route('sliders.index') }}" class="btn btn-sm btn-primary">Back</a>
    </div>
  </div>

  <!-- /.card-header -->
  <div class="card-body" style="display: block;">

    <div class="row">
      <div class="col-md-12">
        <div class="form-group">
            <label>Title </label>
            <input value="{{ old('title') }}" name="title" type="text" class="form-control">
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <div class="form-group">
            <label>Sub Title </label>
            <input value="{{ old('sub_title') }}" name="sub_title" type="text" class="form-control">
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <div class="form-group">
            <label>Call to Action link</label>
            <input value="{{ old('link') }}" name="link" type="text" class="form-control">
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <div class="form-group">
            <label>Image * <span style="font-size:0.5rem">Will be used as thumbnail if video uploaded | size (1920x1024 px) </span> </label>
            <input name="image" type="file" class="form-control">
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <div class="form-group">
            <label>Video </label>
            <input name="video" type="file" class="form-control">
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <div class="form-group">
            <label>Publish</label>
            <select class="form-control" name="is_active">
              <option value="1">Publish</option>
              <option value="0">Unpublish</option>
            </select>
        </div>
      </div>
    </div>


  </div>
  <!-- /.card-body -->
  <div class="card-footer" style="display: block;">
    <button type="submit" class="btn btn-primary">Create Slider</button>
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

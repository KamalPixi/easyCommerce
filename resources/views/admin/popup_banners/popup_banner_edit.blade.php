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
<form action="@if(Route::has('popup_banners.update')) {{ route('popup_banners.update', $popup_banner->id) }} @endif" method="POST" enctype="multipart/form-data">
@CSRF
@method('patch')
<div class="card card-default">

  <div class="card-header">
    <h3 class="card-title">
      <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
      Edit Popup Banner
    </h3>
    <div class="card-tools">
      <a href="{{ route('popup_banners.index') }}" class="btn btn-sm btn-primary">Back</a>
    </div>
  </div>

  <!-- /.card-header -->
  <div class="card-body" style="display: block;">

      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
              <label>Show on Page *</label>
              <select class="form-control" name="show_on_page">
                <option @if($popup_banner->show_on_page == 'home') selected @endif value="home">Home</option>
                <option @if($popup_banner->show_on_page == 'contact') selected @endif value="contact">Contact</option>
                <option @if($popup_banner->show_on_page == 'about') selected @endif value="about">About Page</option>
              </select>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
              <label>Call to Action(URL) </label>
              <input type="text" name="call_to_action" value="{{ $popup_banner->call_to_action ?? '' }}" class="form-control" placeholder="Where customers will be taken?">
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
              <label>Title</label>
              <input type="text" name="title" value="{{ $popup_banner->title ?? '' }}" class="form-control" placeholder="Enter the healine...">
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
              <label>Description</label>
              <textarea name="description" rows="8" cols="80" class="form-control" placeholder="Enter the message...">{{ $popup_banner->description ?? '' }}</textarea>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
              <label>Banner Image</label>
              <input type="file" name="image" class="form-control">
              <img src="{{ asset('storage/media/'.$popup_banner->image) }}" alt="" width="40">
          </div>
        </div>
      </div>

    <div class="row">
      <div class="col-md-12">
        <div class="form-group">
            <label>Publish *</label>
            <select class="form-control" name="publish">
              <option value="1" @if($popup_banner->publish == 1) selected @endif>Publish</option>
              <option value="0" @if($popup_banner->publish == 0) selected @endif>Unpublish</option>
            </select>
        </div>
      </div>
    </div>


  </div>
  <!-- /.card-body -->
  <div class="card-footer" style="display: block;">
    <button type="submit" class="btn btn-primary">Update Popup Banner</button>
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

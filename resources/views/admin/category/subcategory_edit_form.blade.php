@extends('admin.app')

@section('content')

<div class="wrapper">
@include('admin.includes.nav')
@include('admin.includes.aside')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!--breadcrumb-->
@include('admin.includes.breadcrumb')
<!-- Main content -->
<div class="container-fluid">
  @if($errors->any())
      @foreach($errors->all() as $error)
          <div class="alert alert-danger"> {{ $error }} </div>
      @endforeach
  @endif

  @if(Session::has('success'))
      <div class="alert alert-success">
          {{Session::get('success')}}
      </div>
  @endif

  @if(Session::has('fail'))
      <div class="alert alert-danger">
      {{Session::get('fail')}}
      </div>
  @endif


<!-- ### content goes here ####-->

<!-- Product Basic -->
<div class="card card-default">
  <form id="form_category" action="@if(Route::has('subcategories.update')) {{ route('subcategories.update', $sub_category->id) }} @endif" method="POST">
    @CSRF
    @method('PATCH')
  <div class="card-header">
    <h3 class="card-title">Create SubCategory</h3>

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
          <label for="category">Category</label>
          <select name="category_id" class="custom-select " id="category">
            @foreach($categories as $category)
            <option @if($category->id == $sub_category->category_id) selected @endif value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
          </select>
        </div>

        <div class="form-group">
            <label for="subcategory_name">SubCategory Name *</label>
            <input value="{{ $sub_category->name }}" type="text" onkeyup="createSlug(this, 'sub_category_slug')" class="form-control" name="sub_category_name" id="subcategory_name" placeholder="Enter subcategory name">
        </div>
        <div class="form-group">
            <label for="category_slug">Slug *</label>
            <input value="{{ $sub_category->slug }}" id="sub_category_slug" type="text" name="sub_category_slug" class="form-control" placeholder="Enter slug">
        </div>
        <div class="form-group">
            <label for="meta_title">Meta Title</label>
            <input value="{{ $sub_category->meta_title }}" type="text" name="meta_title" class="form-control" id="meta_title" placeholder="Enter meta title">
        </div>
        <div class="form-group">
            <label for="meta_desc">Meta Description</label>
            <textarea name="meta_desc" id="" cols="30" rows="3" class="form-control" placeholder="Enter meta description">{{ $sub_category->meta_description }}</textarea>
        </div>
        <div class="form-group">
          <label for="status">Status</label>
          <select name="status" class="custom-select " id="status">
              <option @if($sub_category->is_active == 1) selected @endif value="1">Active</option>
              <option @if($sub_category->is_active == 0) selected @endif value="0">Deactive</option>
          </select>
        </div>

      </div>
    </div>
    <!-- /.row -->




  </div>
  <!-- /.card-body -->
  <div class="card-footer" style="display: block;">
    <button type="submit" class="btn btn-primary">Update SubCategory</button>
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

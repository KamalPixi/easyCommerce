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
<div class="card card-default">
  <form id="form_category" action="@if(Route::has('subcategories.store')) {{ route('subcategories.store') }} @endif" method="POST">
    @CSRF
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
            <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
          </select>
        </div>

        <div class="form-group">
            <label for="subcategory_name">SubCategory Name *</label>
            <input value="" type="text" onkeyup="createSlug(this, 'sub_category_slug')" class="form-control" name="sub_category_name" id="subcategory_name" placeholder="Enter subcategory name">
        </div>
        <div class="form-group">
            <label for="category_slug">Slug *</label>
            <input value="" id="sub_category_slug" type="text" name="sub_category_slug" class="form-control" placeholder="Enter slug">
        </div>
        <div class="form-group">
            <label for="meta_title">Meta Title</label>
            <input value="" type="text" name="meta_title" class="form-control" id="meta_title" placeholder="Enter meta title">
        </div>
        <div class="form-group">
            <label for="meta_desc">Meta Description</label>
            <textarea name="meta_desc" id="" cols="30" rows="3" class="form-control" placeholder="Enter meta description"></textarea>
        </div>
        <div class="form-group">
          <label for="active_subcategory">Status</label>
          <select name="status" class="custom-select " id="status">
              <option value="1">Active</option>
              <option value="0">Deactive</option>
          </select>
        </div>

      </div>
    </div>
    <!-- /.row -->




  </div>
  <!-- /.card-body -->
  <div class="card-footer" style="display: block;">
    <button type="submit" class="btn btn-primary">Create SubCategory</button>
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

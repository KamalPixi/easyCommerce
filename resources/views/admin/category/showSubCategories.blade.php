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


<div class="row">
<div class="col-12">
<div class="card">
    <div class="card-header">
    <h3 class="card-title">Sub Catgories</h3>

    <div class="card-tools">
        <div class="input-group input-group-sm" style="width: 150px; justify-content:right">
            <a href="{{ route('category.create',['tab'=>'sub-category']) }}" class="btn btn-primary btn-sm">Create Sub-Category</a>
        </div>
    </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body table-responsive p-0">
    <table class="table table-hover text-nowrap">
        <thead>
        <tr>
            <th>ID</th>
            <th>Category</th>
            <th>Sub-Category</th>
            <th>Options</th>
        </tr>
        </thead>
        <tbody>
        @if(isset($categories))
            @foreach($categories as $key => $category)
                @foreach ($category->childrenCategories()->get() as $key_02 => $subCategory)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $category->name }}</td>
                    <td>{{ $subCategory->name }}</td>
                    <td style="width:1.5rem;">
                        <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                        <div class="btn-group" role="group">
                            <button id="btnGroupDrop1" type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Action
                            </button>
                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                            <a class="dropdown-item" href="@if( Route::has('admin.subcategory.edit') ) {{ route('admin.subcategory.edit', ['id'=>$subCategory->id, 'tab'=>'sub-category']) }} @endif">Edit</a>
                            <a class="dropdown-item" href="@if( Route::has('admin.subcategory.delete') ) {{ route('admin.subcategory.delete', ['id'=>$subCategory->id]) }} @endif">Delete</a>
                            </div>
                        </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            @endforeach
        @endif
        </tbody>
    </table>
    </div>
    <!-- /.card-body -->
</div>
<!-- /.card -->
</div>
</div>
<!-- /.row -->



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

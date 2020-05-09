@extends('admin.app')

@section('content')
<div class="wrapper">
@include('admin.includes.nav')
@include('admin.includes.aside', ['data'=>'some data'])

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!--breadcrumb-->
@include('admin.includes.breadcrumb')
<!-- Main content -->
<div class="container-fluid">

@if(Session::has('fail'))
    <div class="alert alert-danger">
        {{ Session::get('fail') }}
    </div>
@endif

@if(Session::has('success'))
    <div class="alert alert-success">
        {{ Session::get('success') }}
    </div>
@endif

<div class="row">
<div class="col-12">
<div class="card">
    <div class="card-header">
    <h3 class="card-title">Catgories</h3>

    <div class="card-tools">
        <div class="input-group input-group-sm" style="width: 150px; justify-content:right">
            <a href="@if(Route::has('categories.create')){{ route('categories.create') }} @endif" class="btn btn-primary btn-sm">Create Category</a>
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
            <th>Options</th>
        </tr>
        </thead>
        <tbody>
        @if(isset($categories))
            @foreach($categories as $key => $category)
            <tr>
                <td>{{ $key+1}}</td>
                <td>{{ $category->name }}</td>
                <td style="width:1.5rem;">
                    <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                    <div class="btn-group" role="group">
                        <button id="btnGroupDrop1" type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Action
                        </button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                        <a class="dropdown-item" href="@if( Route::has('categories.edit') ) {{ route('categories.edit', $category->id) }} @endif">Edit</a>

                        <form class="" action="@if( Route::has('categories.destroy') ) {{ route('categories.destroy', $category->id) }} @endif" method="POST">
                          @CSRF
                          @method('DELETE')
                          <input class="dropdown-item" type="submit" name="destroy" value="Delete">
                        </form>
                        </div>
                    </div>
                    </div>
                </td>
            </tr>
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

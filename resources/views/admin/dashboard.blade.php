@extends('admin.app')

@section('content')
<div class="wrapper">
    @include('admin.includes.nav')
    @include('admin.includes.aside')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
    <!--breadcrumb-->
    @include('admin.includes.breadcrumb')
    @include('admin.includes.info_box')
    <!-- Main content -->



    <!-- End Main content -->
    </div>
    <!-- /.content-wrapper -->
    @include('admin.includes.footer')
    <!-- /.control-sidebar -->
    @include('admin.includes.side_controll')
</div>
<!-- ./wrapper -->
@endsection('content')

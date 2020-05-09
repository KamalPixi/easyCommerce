@extends('app.app')
@section('content')
  <!--include header-->

  @include('app.includes.header')
  @include('app.error_print')
  @include('app.products.inc.product_inc')

  <!--include footer-->
  @include('app.includes.footer')
@endsection

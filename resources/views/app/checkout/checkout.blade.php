@extends('app.app')
@section('content')
  <!--include header-->

  @include('app.includes.header')
  @include('app.checkout.inc.checkout')

  <!--include footer-->
  @include('app.includes.footer')
@endsection

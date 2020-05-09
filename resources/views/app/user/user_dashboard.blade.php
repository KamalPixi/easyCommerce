@extends('app.app')
@section('content')
  <!--include header-->

  @include('app.includes.header')

  <section class="my-5">
    <div class="container">
      <div class="row">
        <div class="col-lg-3">
          @include('app.user.inc.sidebar')
        </div>
        <div class="col-lg-9">
          @include('app.user.inc.order_masters')
        </div>

      </div>
    </div>
  </section>


  <!--include footer-->
  @include('app.includes.footer')
@endsection

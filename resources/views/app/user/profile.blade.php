@extends('app.app')
@section('content')
  <!--include header-->

  @include('app.includes.header')
  @include('app.error_print')

  <section class="my-5">
    <div class="container">
      <div class="row">
        <div class="col-lg-3">
          @include('app.user.inc.sidebar')
        </div>
        <div class="col-lg-9">
          @include('app.user.inc.profile')
        </div>

      </div>
    </div>
  </section>


  <!--include footer-->
  @include('app.includes.footer')
@endsection

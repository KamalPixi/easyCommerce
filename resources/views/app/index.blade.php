@extends('app.app')
@section('content')
  <!--include header-->

  @push('css')
  <link rel="stylesheet" href="{{ asset('frontend/css/modal_video.min.css') }}">
  @endpush
  @push('js')
    <script src="{{ asset('frontend/js/modal_video.js') }}"></script>
    <script>
      $(".js-video-button").modalVideo({
        youtube:{
          controls:0,
          nocookie: true
        }
      });
    </script>
  @endpush

  @include('app.error_print')
  @include('app.includes.header')
  @include('app.includes.hero')
  @include('app.includes.top_products')
  <!-- @include('app.includes.banner') -->
  @include('app.includes.products')

  <!--include footer-->
  @include('app.includes.footer')
  <!-- popup_banner -->
  @include('app.includes.popup_banner')
@endsection

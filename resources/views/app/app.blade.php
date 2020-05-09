<!DOCTYPE html>
<html lang="en">
<head>
  <!-- CSRF Token -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- meta include -->
  @stack('meta')

  <title>{{ config('app.name', 'E-commerce') }}</title>


  <!-- CSS owl Slider -->
  <link rel="stylesheet" href="{{ asset('frontend/css/owl.carousel.min.css') }}">
  <link rel="stylesheet" href="{{ asset('frontend/css/owl.theme.default.min.css') }}">
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css') }}">
  <!-- SimpleBar -->
  <link rel="stylesheet" href="{{ asset('frontend/css/simplebar.css') }}" />
  <!-- Custom CSS -->
  <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">

  <!--to include custom css -->
  @stack('css')

</head>

<body>

  @yield('content')


  <a href="https://api.whatsapp.com/send?phone=+8801940977996&amp;text=Hi, MedleyMartBD" class="float" target="_blank" style="padding-top:4px">
    <i class="fa fa-whatsapp my-float"></i>
  </a>
  <!-- jQuery library -->
  <script src="{{ asset('frontend/js/jquery.min.js') }}"></script>
  <!-- Popper JS -->
  <script src="{{ asset('frontend/js/popper.min.js') }}"></script>
  <!-- Latest compiled JavaScript -->
  <script src="{{ asset('frontend/js/bootstrap.min.js') }}"></script>
  <!-- Font Awesome -->
  <script src="{{ asset('frontend/js/kit.fontawesome.com.js') }}"></script>
  <!-- SimpleBar -->
  <script src="{{ asset('frontend/js/simplebar.min.js') }}"></script>
  <!-- jQuery owl Slider -->
  <script src="{{ asset('frontend/js/owl.carousel.min.js') }}"></script>
  <!-- Custom Function JS -->
  <script src="{{ asset('frontend/js/func.js') }}"></script>

  <script src="{{ asset('frontend/js/notify.min.js') }}"></script>
  <!--to include custom js -->
  @stack('js')
  <!-- Custom JS -->
  <script src="{{ asset('frontend/js/main.js') }}"></script>
</body>
</html>

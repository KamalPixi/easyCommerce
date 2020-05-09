<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'AppName') }} :: Admin Dashboard</title>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('backend/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('backend/dist/css/adminlte.min.css') }}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!--to inject css -->
    @stack('css')
    <!-- custom css -->
    <link rel="stylesheet" href="{{ asset('backend/dist/css/custom.css') }}">

</head>

<body class="hold-transition sidebar-mini
  @if(Route::is('admn.login.show') ||
  Route::is('admin.reset.form') ||
  Route::is('admin.reset.token')
  ) login-page @endif">
  <div id="flash-container"></div>

    @yield('content')

    <!-- jQuery -->
    <script src="{{ asset('backend/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('backend/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('backend/dist/js/adminlte.min.js') }}"></script>
    <!--to inject js -->
    @stack('js')
    <!-- Custom js -->
    <script src="{{ asset('backend/dist/js/custom.js') }}"></script>
</body>
</html>

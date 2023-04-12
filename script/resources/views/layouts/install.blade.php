<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>@yield('title')</title>

  <!-- General CSS Files -->
  <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/css/font-awesome.css') }}" rel="stylesheet">

  <!-- CSS Libraries -->
  @stack('styles')

  <!-- Template CSS -->
  <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/css/components.css') }}" rel="stylesheet">
</head>

<body>
  <div id="app">
    <section class="section">
     @yield('content')
    </section>
  </div>

    <!-- General JS Scripts -->
    <script src="{{ asset('assets/js/vendor/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/moment.min.js') }}"></script>
  
    <!-- JS Libraies -->
    @stack('libraies')
  
    <!-- Template JS File -->
    <script src="{{ asset('assets/js/scripts.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>
  
    <!-- Page Specific JS File -->
    @stack('scripts')


</body>
</html>

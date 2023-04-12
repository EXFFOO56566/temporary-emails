<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{$setdata['name']}}</title>
    <link rel="icon" type="image/png" href="{{asset($setdata['favicon'])}}" />

    <!-- General CSS Files -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/font-awesome.css') }}" rel="stylesheet">

    <!-- CSS Libraries -->
    @stack('styles')

    <!-- Template CSS -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/components.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet">
</head>

<body>
    <div id="app">
        <div class="main-wrapper">
            <div class="navbar-bg"></div>

            @include('layouts.header')

            @include('layouts.sidebar')

            <!-- Main Content -->
            <div class="main-content">
                @yield('content')
            </div>
            <footer class="main-footer">
                <div class="footer-left">
                    {{ __('Copyright')}} &copy; {{date('Y')}} <div class="bullet"></div> {{ __('Powered By')}}
                    <a href="{{$setdata['site_url']}}">{{Str::limit($setdata['name'], 16)}}</a>
                </div>
                <div class="footer-right">
                    1.4v
                </div>
            </footer>
        </div>
    </div>

    <!-- General JS Scripts -->
    <script src="{{ asset('assets/js/vendor/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/index.umd.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/sweetalert2.js') }}"></script>

    <!-- JS Libraies -->
    @stack('libraies')

    <!-- Template JS File -->
    <script src="{{ asset('assets/js/scripts.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>

    @stack('scripts')
    @if (session()->has('success'))
    <!--SET DYNAMIC VARIABLE IN SCRIPT -->
    <script type="text/javascript">
        var alert = '{{session()->get('success')}}';
      var icon  = 'success';
    </script>
    <script src="{{ asset('assets/js/vendor/alert.js') }}"></script>
    @endif
    @if (session()->has('demo'))
    <!--SET DYNAMIC VARIABLE IN SCRIPT -->
    <script type="text/javascript">
        var alert = '{{session()->get('demo')}}';
      var icon  = 'error';
    </script>
    <script src="{{ asset('assets/js/vendor/alert.js') }}"></script>
    @endif
    @if (session()->has('error'))
    <!--SET DYNAMIC VARIABLE IN SCRIPT -->
    <script type="text/javascript">
        var alert = '{{session()->get('error')}}';
    var icon  = 'error';
    </script>
    <script src="{{ asset('assets/js/vendor/alert.js') }}"></script>
    @endif

    <script type="text/javascript">
        "use strict";
            const BASE_URL = "{{ url('/admin') }}";
    </script>

</body>

</html>
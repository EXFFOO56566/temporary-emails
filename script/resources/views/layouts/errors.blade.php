<!DOCTYPE html>
<html lang="en">

<head>
    <title>@yield('title')</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- font awesome icons -->
    <link href="{{ asset('assets/css/font-awesome.css') }}" rel="stylesheet">
    <!-- bootstrap css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- main css -->
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    @if (env('SYSTEM_INSTALLED') != 0)

    <link rel="icon" type="image/png" href="{{asset($setdata['favicon'])}}" />
    <!--SET DYNAMIC VARIABLE IN STYLE-->
    <style>
        :root {
          --main-color: {{$setdata['main_color']}};
          --color1: {{$setdata['secondary_color']}};
        }
      </style>
    @endif
</head>

<body class="error_page">
    <div class="full-screen-size-fixed-container d-flex justify-content-center align-items-center">
        <div class="p-3 text-center">
            <h1 class="display-1 font-weight-bold ">@yield('code')</h1>
            <h4 class="text-muted">@yield('message')</h4>
            <p class="mb-4">@yield('message2')</p>
            <a class="btn-2" href="{{url('/')}}" role="button"><i
                    class="fas fa-house-user mr-2"></i>{{translate('Back to Home')}}</a>
        </div>
        
    </div>

</body>
</html>
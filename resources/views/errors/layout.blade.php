<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title')</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'NiaEvents') }} | @yield('title', 'Portal')</title>

    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,800" rel="stylesheet" />

    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <!-- CSS Files -->

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;600;700&family=Poppins:ital,wght@0,200;0,300;1,200;1,300&display=swap"
        rel="stylesheet">

    {{-- Favicon --}}
    <link id="favicon" rel="shortcut icon" href="{{asset('favicon-dark.png')}}" type="image/x-icon">

    {{-- Custom CSS --}}
    <link rel="stylesheet" href="{{ asset('resources/css/custom.css') }}">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    {{-- Soft-ui-dashboard CSS --}}
    <link id="pagestyle" href="{{asset('/resources/assets/css/soft-ui-dashboard.css')}}" rel="stylesheet" />

    <!-- Toastr CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">


    <!-- Styles -->
    <style>
        html,
        body {
            background-color: #fff;
            color: #636b6f;
            font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
            font-weight: 100;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 36px;
            padding: 20px;
        }
    </style>

</head>

<body>
    <div class="flex-center position-ref full-height">
        <div class="content">
        <div class="logo m-2">
            <img src="{{asset('/resources/logo.png')}}" width="200" class="navbar-brand-img h-100" alt="main_logo">
        </div>
            <div class="title fw-bold text-dark fs-1 d-flex flex-column align-items-center">
                @yield('message')
                <div class="container mt-3">
                    <div class="container d-flex justify-content-center">
                        <a href="/" class="btn btn-dark bg-gradient mb-3"><i class="fa fa-plus me-1"></i>Go
                            to Dashboard</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="{{ asset('/resources/assets/js/soft-ui-dashboard.js')}}"></script>
    <script src="{{ asset('/resources/assets/js/soft-ui-dashboard.min.js')}}"></script>
</body>

</html>
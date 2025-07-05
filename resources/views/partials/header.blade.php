<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">


<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'NiaEvents') }} | @yield('title', 'Portal')</title>

    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,800" rel="stylesheet" />

    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <!-- CSS Files -->

    <!-- Fonts -->
    {{--
    <link rel="dns-prefetch" href="//fonts.bunny.net"> --}}
    {{--
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet"> --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;600;700&family=Poppins:ital,wght@0,200;0,300;1,200;1,300&display=swap"
        rel="stylesheet">
    <!-- TUI Calendar CSS & JS -->
    <link rel="stylesheet" href="https://uicdn.toast.com/calendar/latest/toastui-calendar.min.css" />
    <script src="https://uicdn.toast.com/calendar/latest/toastui-calendar.min.js"></script>
    <!-- Toast UI CSS -->
    <link rel="stylesheet" href="{{ asset('vendor/toastui-calendar/toastui-calendar.min.css') }}">



    <!-- Toast UI JS -->
    <script src="{{ asset('vendor/toastui-calendar/toastui-calendar.min.js') }}"></script>


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

    <!-- FullCalendar CSS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet" />

    {{--
    <link id="pagestyle" href="{{asset('/resources/assets/css/soft-ui-dashboard.min.css')}}" rel="stylesheet" /> --}}

</head>

<body class="bg-gray-100">
    <div id="page-preloader" style="
    position: fixed;
    top: 0; left: 0; right: 0; bottom: 0;
    background: #fff;
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
">
        <div class="spinner-grow text-dark" style="width: 3rem; height: 3rem;" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <div id="app">
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    {{-- <link rel="dns-prefetch" href="//fonts.bunny.net"> --}}
    {{-- <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet"> --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;600;700&family=Poppins:ital,wght@0,200;0,300;1,200;1,300&display=swap" rel="stylesheet">
    <!-- TUI Calendar CSS & JS -->
    <link rel="stylesheet" href="https://uicdn.toast.com/calendar/latest/toastui-calendar.min.css" />
    <script src="https://uicdn.toast.com/calendar/latest/toastui-calendar.min.js"></script>
    <!-- Toast UI CSS -->
    <link rel="stylesheet" href="{{ asset('vendor/toastui-calendar/toastui-calendar.min.css') }}">

    <!-- Toast UI JS -->
    <script src="{{ asset('vendor/toastui-calendar/toastui-calendar.min.js') }}"></script>


    {{-- Favicon --}}
    <link rel="shortcut icon" href="{{asset('resources/invite-card-logo.png')}}" type="image/x-icon">

    {{-- Custom CSS --}}
    <link rel="stylesheet" href="{{ asset('resources/css/custom.css') }}">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        @include('partials.navbar')
    
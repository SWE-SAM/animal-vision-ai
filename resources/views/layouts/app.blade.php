<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel Dashboard') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>

            <!-- Navbar -->
            @include('partials.navbar')

            <!-- Sidebar -->
            @include('partials.sidebar')

            <!-- Main Content -->
            <div class="main-content">
                <section class="section">
                    @yield('content') {{-- This is where dashboard and other pages will load --}}
                </section>
            </div>

            <!-- Footer -->
            <footer class="main-footer">
                <div class="footer-left">
                    Copyright &copy; 2025 <div class="bullet"></div> Design By Your Team
                </div>
                <div class="footer-right"></div>
            </footer>
        </div>
    </div>

    <!-- General JS Scripts -->
    <script src="{{ asset('assets/modules/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/modules/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.js') }}"></script>
</body>
</html>

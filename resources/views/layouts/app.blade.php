<!DOCTYPE html>
<html
    lang="en"
    dir="ltr"
    data-nav-layout="vertical"
    data-theme-mode="light"
    data-header-styles="light"
    data-menu-styles="light"
    data-toggled="close"
>
    <head>
        <!-- Meta Data -->
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <title>App Name - @yield('title')</title>
        <meta name="Description" content="Dashboard Page" />

        <!-- Favicon -->
        <link
            rel="icon"
            href="{{ asset('assets/images/logo-kkp.png') }}"
        />

        <!-- Choices JS -->
        <script src="{{ asset('assets/libs/choices.js/public/assets/scripts/choices.min.js') }}"></script>

        <!-- Main Theme Js -->
        <script src="{{ asset('assets/js/main.js') }}"></script>

        <!-- Bootstrap Css -->
        <link
            id="style"
            href="{{ asset('assets/libs/bootstrap/css/bootstrap.min.css') }}"
            rel="stylesheet"
        />

        <!-- Style Css -->
        <link href="{{ asset('assets/css/styles.min.css') }}" rel="stylesheet" />

        <!-- Icons Css -->
        <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" />

        <!-- Node Waves Css -->
        <link href="{{ asset('assets/libs/node-waves/waves.min.css') }}" rel="stylesheet" />

        <!-- Simplebar Css -->
        <link
            href="{{ asset('assets/libs/simplebar/simplebar.min.css') }}"
            rel="stylesheet"
        />

        <!-- Color Picker Css -->
        <link
            rel="stylesheet"
            href="{{ asset('assets/libs/flatpickr/flatpickr.min.css') }}"
        />
        <link
            rel="stylesheet"
            href="{{ asset('assets/libs/@simonwep/pickr/themes/nano.min.css') }}"
        />

        <!-- Choices Css -->
        <link
            rel="stylesheet"
            href="{{ asset('assets/libs/choices.js/public/assets/styles/choices.min.css') }}"
        />

        <!-- Jsvector Css -->
        <link
            rel="stylesheet"
            href="{{ asset('assets/libs/jsvectormap/css/jsvectormap.min.css') }}"
        />

        <!-- Swiper Css -->
        <link
            rel="stylesheet"
            href="{{ asset('assets/libs/swiper/swiper-bundle.min.css') }}"
        />

        <!-- Grid Css -->
        <link
            rel="stylesheet"
            href="{{ asset('assets/libs/gridjs/theme/mermaid.min.css') }}"
        />

        @stack('styles')

        <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet">

    </head>

    <body>
        @include('partials.switcher')
        @include('partials.loader')

        <div class="page">

            @include('components.header')
            @include('components.sidebar')

            @yield('content')
        </div>

        {{-- @include('components.footer') --}}

        <!-- Popper JS -->
        <script src="{{ asset('assets/libs/@popperjs/core/umd/popper.min.js') }}"></script>

        <!-- Bootstrap JS -->
        <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

        <!-- Defaultmenu JS -->
        <script src="{{ asset('assets/js/defaultmenu.min.js') }}"></script>

        <!-- Node Waves JS-->
        <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>

        <!-- Sticky JS -->
        <script src="{{ asset('assets/js/sticky.js') }}"></script>

        <!-- Simplebar JS -->
        <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
        <script src="{{ asset('assets/js/simplebar.js') }}"></script>

        <!-- Color Picker JS -->
        <script src="{{ asset('assets/libs/@simonwep/pickr/pickr.es5.min.js') }}"></script>

        <!-- JSVector Maps JS -->
        <script src="{{ asset('assets/libs/jsvectormap/js/jsvectormap.min.js') }}"></script>

        <!-- JSVector Maps MapsJS -->
        <script src="{{ asset('assets/libs/jsvectormap/maps/world-merc.js') }}"></script>
        
        <!-- Custom-Switcher JS -->
        <script src="{{ asset('assets/js/custom-switcher.min.js') }}"></script>

        <!-- Custom JS -->
        <script src="{{ asset('assets/js/custom.js') }}"></script>

        @stack('scripts')
    </body>
</html>

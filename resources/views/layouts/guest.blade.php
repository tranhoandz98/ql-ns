<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    class=" layout-navbar-fixed layout-menu-fixed layout-compact " dir="ltr" data-skin="default"
    data-template="vertical-menu-template" data-bs-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>
    <meta name="description" content="Phần mềm quản lý nhân sự top 1 Việt Nam" />

    <!-- Fonts -->
    {{-- <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap"> --}}
    <link rel="icon" type="image/x-icon"
        href="https://demos.pixinvent.com/vuexy-html-admin-template/assets/img/favicon/favicon.ico" />
    <link rel="preconnect" href="https://fonts.googleapis.com/" />
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&amp;ampdisplay=swap"
        rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/iconify-icons.css') }}" />

    <!-- Core CSS -->
    <!-- build:css assets/vendor/css/theme.css  -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/node-waves/node-waves.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/pickr/pickr-themes.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/core.css') }}" />

    <!-- Vendors CSS -->

    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <!-- endbuild -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/spinkit/spinkit.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/notiflix/notiflix.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/notyf/notyf.css') }}" />

    @yield('css-vendor')
    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    {{-- <script src="{{ asset('assets/vendor/js/template-customizer.js') }}"></script> --}}

    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('assets/js/config.js') }}"></script>
    @yield('css')

</head>

<body>
    <!-- Layout wrapper -->
    <div class="authentication-wrapper authentication-cover">
        {{ $slot }}
    </div>
    <button class="btn btn-primary btn-page-block-spinner d-none" id="btn-page-block-spinner">Overlay Color</button>
    <button class="btn btn-primary remove-page-btn d-none" id="remove-page-btn">remove/unblock</button>

    <!-- / Layout wrapper -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/theme.js -->


    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>

    <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/node-waves/node-waves.js') }}"></script>


    <script src="{{ asset('assets/vendor/libs/%40algolia/autocomplete-js.js') }}"></script>



    <script src="{{ asset('assets/vendor/libs/pickr/pickr.js') }}"></script>



    <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>


    <script src="{{ asset('assets/vendor/libs/hammer/hammer.js') }}"></script>

    <script src="{{ asset('assets/vendor/js/menu.js') }}"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->
    @yield('script-vendor')
    <script src="{{ asset('assets/vendor/libs/notiflix/notiflix.js') }}"></script>
    <script src="{{ asset('assets/js/extended-ui-blockui.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/notyf/notyf.js') }}"></script>
    <!-- Main JS -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <!-- Page JS -->
    <script src="{{ asset('assets/js/extended-ui-blockui.js') }}"></script>
    <script src="{{ asset('assets/js/app/app-block-ui.js') }}"></script>
    <script src="{{ asset('assets/js/app/app-toast.js') }}"></script>
    @if (session('status'))
        <script>
            showAlert('{{ session('status') }}', '{{ session('message') }}');
        </script>
    @endif
    @yield('script')
</body>

</html>

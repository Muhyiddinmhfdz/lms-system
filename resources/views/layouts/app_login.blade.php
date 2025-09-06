<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<!--begin::Head-->
<head>
    <base href="{{ url('/') }}"/>
    <title>Sistem-LMS</title>
    <meta charset="utf-8" />
    <meta name="description" content="Sistem-LMS" />
    <meta name="keywords" content="Sistem-LMS" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="Sistem-LMS" />
    <meta property="og:url" content="{{ url('/') }}" />
    <meta property="og:site_name" content="Sistem-LMS" />
    <link rel="canonical" href="{{ url('/') }}" />
    <link rel="shortcut icon" href="{{ asset('assets/media/logo-white.png') }}" />
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <!-- Global Styles -->
    <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<!--end::Head-->
<!--begin::Body-->
<body id="kt_body" class="app-blank bgi-size-cover bgi-attachment-fixed bgi-position-center bgi-no-repeat">
    <div class="d-flex flex-column flex-root" id="kt_app_root">
        @yield('content')
    </div>

    <!--begin::Javascript-->
    <script>var hostUrl = "{{ asset('assets') }}/";</script>
    <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
    @yield('script')
    <!--end::Javascript-->
</body>
</html>
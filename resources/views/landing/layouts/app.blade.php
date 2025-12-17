<!doctype html>
<html class="no-js" lang="zxx">

<head>
    @include('landing.layouts.head')
    @yield('style')
</head>

<body>
    <!-- navbar -->
    @include('landing.layouts.navbar')

    <!-- navbar-end -->

    <!-- main-area -->
    @yield('content')
    <!-- main-area-end -->

    <!-- footer -->
    @include('landing.layouts.footer')

    <!-- footer-end -->

    <!-- JS here -->
    @include('landing.layouts.script')

</body>

</html>

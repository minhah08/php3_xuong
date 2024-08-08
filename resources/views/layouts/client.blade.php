<!doctype html>
<html class="no-js" lang="zxx">


<!-- Mirrored from htmldemo.net/corano/corano/product-details.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 29 Jun 2024 09:54:00 GMT -->
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Corano - Jewelry Shop eCommerce Bootstrap 5 Template</title>
    <meta name="robots" content="noindex, follow" />
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/clients/img/favicon.ico') }}">

    <!-- CSS
	============================================ -->
    <!-- google fonts -->
    <link href="https://fonts.googleapis.com/css?family=Lato:300,300i,400,400i,700,900" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets/clients/css/vendor/bootstrap.min.css') }}">
    <!-- Pe-icon-7-stroke CSS -->
    <link rel="stylesheet" href="{{ asset('assets/clients/css/vendor/pe-icon-7-stroke.css') }}">
    <!-- Font-awesome CSS -->
    <link rel="stylesheet" href="{{ asset('assets/clients/css/vendor/font-awesome.min.css') }}">
    <!-- Slick slider css -->
    <link rel="stylesheet" href="{{ asset('assets/clients/css/plugins/slick.min.css') }}">
    <!-- animate css -->
    <link rel="stylesheet" href="{{ asset('assets/clients/css/plugins/animate.css') }}">
    <!-- Nice Select css -->
    <link rel="stylesheet" href="{{ asset('assets/clients/css/plugins/nice-select.css') }}">
    <!-- jquery UI css -->
    <link rel="stylesheet" href="{{ asset('assets/clients/css/plugins/jqueryui.min.css') }}">
    <!-- main style css -->
    <link rel="stylesheet" href="{{ asset('assets/clients/css/style.css') }}">
    @yield('css')
</head>

<body>
    <!-- Start Header Area -->

    <!-- end Header Area -->

    @include('clients.blocks.header')
    <main>
        @yield('content')
    </main>

    <!-- Scroll to top start -->
    <div class="scroll-top not-visible">
        <i class="fa fa-angle-up"></i>
    </div>
    <!-- Scroll to Top End -->

    <!-- footer area start -->
    @include('clients.blocks.footer')
    <!-- footer area end -->


    <!-- JS
============================================ -->

    <!-- Modernizer JS -->
    <script src="{{ asset('assets/clients/js/vendor/modernizr-3.6.0.min.js') }}"></script>
    <!-- jQuery JS -->
    <script src="{{ asset('assets/clients/js/vendor/jquery-3.6.0.min.js') }}"></script>
    <!-- Bootstrap JS -->
    <script src="{{ asset('assets/clients/js/vendor/bootstrap.bundle.min.js') }}"></script>
    <!-- slick Slider JS -->
    <script src="{{ asset('assets/clients/js/plugins/slick.min.js') }}"></script>
    <!-- Countdown JS -->
    <script src="{{ asset('assets/clients/js/plugins/countdown.min.js') }}"></script>
    <!-- Nice Select JS -->
    <script src="{{ asset('assets/clients/js/plugins/nice-select.min.js') }}"></script>
    <!-- jquery UI JS -->
    <script src="{{ asset('assets/clients/js/plugins/jqueryui.min.js') }}"></script>
    <!-- Image zoom JS -->
    <script src="{{ asset('assets/clients/js/plugins/image-zoom.min.js') }}"></script>
    <!-- Images loaded JS -->
    <script src="{{ asset('assets/clients/js/plugins/imagesloaded.pkgd.min.js') }}"></script>
    <!-- mail-chimp active js -->
    <script src="{{ asset('assets/clients/js/plugins/ajaxchimp.js') }}"></script>
    <!-- contact form dynamic js -->
    <script src="{{ asset('assets/clients/js/plugins/ajax-mail.js') }}"></script>
    <!-- google map api -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCfmCVTjRI007pC1Yk2o2d_EhgkjTsFVN8"></script>
    <!-- google map active js -->
    <script src="{{ asset('assets/clients/js/plugins/google-map.js') }}"></script>
    <!-- Main JS -->
    <script src="{{ asset('assets/clients/js/main.js') }}"></script>

    @yield('js')
</body>


<!-- Mirrored from htmldemo.net/corano/corano/product-details.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 29 Jun 2024 09:54:00 GMT -->
</html>
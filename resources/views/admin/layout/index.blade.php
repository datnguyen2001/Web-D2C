<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>
        @if (isset($titlePage))
            {{$titlePage}}
        @else
            @yield('title')
        @endif
    </title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicons -->
    <link href="{{asset('assets/images/logo.png')}}" rel="icon">
    <link href="{{asset('assets/images/logo.png')}}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{asset('assets/admin/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/admin/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
    <link href="{{asset('assets/admin/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/admin/vendor/quill/quill.snow.css')}}" rel="stylesheet">
    <link href="{{asset('assets/admin/vendor/quill/quill.bubble.css')}}" rel="stylesheet">
    <link href="{{asset('assets/admin/vendor/remixicon/remixicon.css')}}" rel="stylesheet">
    <link href="{{asset('assets/admin/vendor/simple-datatables/style.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <!-- Template Main CSS File -->
    <link href="{{asset('assets/admin/css/style.css')}}" rel="stylesheet">
    @yield('style')
</head>
<body class="bg-neutral">
<!-- Header -->
@include('admin.layout.top-menu')
@include('admin.layout.main-menu')
<!-- End header -->
@yield('main')
<!-- Footer -->
@include('admin.layout.footer')
<!-- Vendor JS Files -->
<script src="{{asset('assets/admin/vendor/apexcharts/apexcharts.min.js')}}"></script>
<script src="{{asset('assets/admin/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('assets/admin/vendor/chart.js/chart.min.js')}}"></script>
<script src="{{asset('assets/admin/vendor/echarts/echarts.min.js')}}"></script>
<script src="{{asset('assets/admin/vendor/quill/quill.min.js')}}"></script>
<script src="{{asset('assets/admin/vendor/simple-datatables/simple-datatables.js')}}"></script>
<script src="{{asset('assets/admin/vendor/tinymce/tinymce.min.js')}}"></script>
<script src="{{asset('assets/admin/vendor/php-email-form/validate.js')}}"></script>

<!-- Template Main JS File -->
<script src="{{asset('assets/admin/js/main.js')}}"></script>
<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery.repeater@1.2.1/jquery.repeater.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.responsivevoice.org/responsivevoice.js?key=ZDwUpEfF"></script>
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<!--end::Global Theme Bundle-->
@yield('script')
<div class="loading"></div>
<div id="overlay"></div>

<!-- END: Content-->
<div class="sidenav-overlay" style=""></div>
<div class="drag-target"></div>
</body>
</html>

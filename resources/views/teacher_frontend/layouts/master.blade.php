<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
    <meta name="author" content="Coderthemes">

{{--    <link rel="shortcut icon" href="assets/images/favicon.ico">--}}

    <title>@yield('title')</title>

    <!-- Custom box css -->
    <link href="{{ URL::asset('../plugins/custombox/dist/custombox.min.css') }}" rel="stylesheet">

    <link href="{{ URL::asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/css/icons.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/css/style.css') }}" rel="stylesheet" type="text/css" />

    <script src="{{ URL::asset('assets/js/modernizr.min.js') }}"></script>

</head>

<body class="fixed-left">

<!-- Begin page -->
<div id="wrapper">

    @include('teacher_frontend.layouts.header')
    @include('teacher_frontend.layouts.sidebar')

    @yield('content')

</div>
<!-- END wrapper -->

<script>
    var resizefunc = [];
</script>


<!-- jQuery  -->
<script src="{{ URL::asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/detect.js') }}"></script>
<script src="{{ URL::asset('assets/js/fastclick.js') }}"></script>
<script src="{{ URL::asset('assets/js/jquery.slimscroll.js') }}"></script>
<script src="{{ URL::asset('assets/js/jquery.blockUI.js') }}"></script>
<script src="{{ URL::asset('assets/js/waves.js') }}"></script>
<script src="{{ URL::asset('assets/js/wow.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/jquery.nicescroll.js') }}"></script>
<script src="{{ URL::asset('assets/js/jquery.scrollTo.min.js') }}"></script>

<!-- Modal-Effect -->
<script src="{{ URL::asset('../plugins/custombox/dist/custombox.min.js') }}"></script>

<!-- App js -->
<script src="{{ URL::asset('assets/js/jquery.core.js') }}"></script>
<script src="{{ URL::asset('assets/js/jquery.app.js') }}"></script>

</body>
</html>

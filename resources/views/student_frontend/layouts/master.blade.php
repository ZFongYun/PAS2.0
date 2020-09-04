<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
    <meta name="author" content="Coderthemes">

    <title>@yield('title')</title>

    <link href="{{ URL::asset('assets_stu/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets_stu/css/icons.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets_stu/css/style.css') }}" rel="stylesheet" type="text/css" />

    <script src="assets_stu/js/modernizr.min.js"></script>

</head>

<body class="fixed-left">

<!-- Begin page -->
<div id="wrapper">

    @include('student_frontend.layouts.header')
    @include('student_frontend.layouts.sidebar')

    @yield('content')

</div>
<!-- END wrapper -->


<script>
    var resizefunc = [];
</script>


<!-- jQuery  -->
<script src="{{ URL::asset('assets_stu/js/jquery.min.js') }}"></script>
<script src="{{ URL::asset('assets_stu/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ URL::asset('assets_stu/js/detect.js') }}"></script>
<script src="{{ URL::asset('assets_stu/js/fastclick.js') }}"></script>
<script src="{{ URL::asset('assets_stu/js/jquery.slimscroll.js') }}"></script>
<script src="{{ URL::asset('assets_stu/js/jquery.blockUI.js') }}"></script>
<script src="{{ URL::asset('assets_stu/js/waves.js') }}"></script>
<script src="{{ URL::asset('assets_stu/js/wow.min.js') }}"></script>
<script src="{{ URL::asset('assets_stu/js/jquery.nicescroll.js') }}"></script>
<script src="{{ URL::asset('assets_stu/js/jquery.scrollTo.min.js') }}"></script>

<!-- App js -->
<script src="{{ URL::asset('assets_stu/js/jquery.core.js') }}"></script>
<script src="{{ URL::asset('assets_stu/js/jquery.app.js') }}"></script>

</body>
</html>

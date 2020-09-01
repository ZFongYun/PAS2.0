<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
    <meta name="author" content="Coderthemes">

    <!-- App title -->
    <title>教師登入</title>

    <!-- App CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/icons.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/style.css" rel="stylesheet" type="text/css" />

    <script src="assets/js/modernizr.min.js"></script>

</head>
<body>

<div class="text-center logo-alt-box">
    <p class="logo"><span class="text-inverse">同儕互評系統<span class="text-custom"> 教師端</span></span></p>
</div>

<div class="wrapper-page">

    <div class="m-t-30 card card-body">
        <div class="text-center">
            <h4 class="text-uppercase font-bold">登入</h4>
        </div>
        <div class="p-2">
            <form class="form-horizontal m-t-10" action="{{action('ProfLoginController@login')}}" method="post">
                {{ csrf_field() }}
                <div class="form-group ">
                    <div class="col-12">
                        <input class="form-control" type="text" required="" name="account" placeholder="帳號">
                    </div>
                </div>

                @if($messageWaining = Session::get('warning'))
                    <label style="color: crimson;font-size: 10px">{{$messageWaining}}</label>
                @endif

                <div class="form-group">
                    <div class="col-12">
                        <input class="form-control" type="password" required="" name="password" placeholder="密碼">
                    </div>
                </div>

                @if($messageWaining = Session::get('warning'))
                    <label style="color: crimson;font-size: 10px">{{$messageWaining}}</label>
                @endif
                @if($messageError = Session::get('error'))
                    <label style="color: crimson;font-size: 10px">{{$messageError}}</label>
                @endif

                <div class="form-group text-center m-t-30">
                    <div class="col-12">
                        <button class="btn btn-custom btn-bordred btn-block waves-effect waves-light text-uppercase" type="submit">登入</button>
                    </div>
                </div>

            </form>

        </div>
    </div>
    <!-- end card-box -->

</div>
<!-- end wrapper page -->

<script>
    var resizefunc = [];
</script>

<!-- jQuery  -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/detect.js"></script>
<script src="assets/js/fastclick.js"></script>
<script src="assets/js/jquery.slimscroll.js"></script>
<script src="assets/js/jquery.blockUI.js"></script>
<script src="assets/js/waves.js"></script>
<script src="assets/js/wow.min.js"></script>
<script src="assets/js/jquery.nicescroll.js"></script>
<script src="assets/js/jquery.scrollTo.min.js"></script>

<!-- App js -->
<script src="assets/js/jquery.core.js"></script>
<script src="assets/js/jquery.app.js"></script>

</body>
</html>

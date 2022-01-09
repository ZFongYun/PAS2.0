@extends('student_frontend.layouts.master')
@section('content')
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">
                <!-- Page-Title -->
                <div class="row">
                    <div class="col-sm-12">
                        <h4 class="page-title">修改密碼</h4>
                        @if($messageWaining = Session::get('warning'))
                            <div class="alert alert-danger alert-block" style="color: #EE5959">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                {{ $messageWaining }}
                            </div>
                        @endif
                        <form action="{{action('ResetPasswordController@update',$id)}}" method="post">
                            <div class="form-group">
                                <label for="new_password">新密碼</label>
                                <input type="password" class="form-control" id="new_password" name="new_password" required="">
                            </div>
                            <div class="form-group">
                                <label for="re_new_password">再次輸入新密碼</label>
                                <input type="password" class="form-control" id="re_new_password" name="re_new_password" required="">
                            </div>
                            <input type="checkbox" onclick="myFunction()"> 顯示密碼
                            <div class="m-t-30" align="center">
                                <button type="submit" class="btn btn-success waves-effect waves-light button-font">修改</button>
                            </div><!-- end col -->
                            <input type="hidden" name="_method" value="PUT">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        </form>
                    </div>
                </div>
            </div> <!-- container-fluid -->
        </div> <!-- content -->
    </div>

    <script>
        function myFunction() {
            var x = document.getElementById("re_new_password");
            var y = document.getElementById("new_password");
            if (x.type === "password" && y.type === "password") {
                x.type = "text";
                y.type = "text";
            } else {
                x.type = "password";
                y.type = "password";
            }
        }
    </script>
@endsection
@section('title','修改密碼')

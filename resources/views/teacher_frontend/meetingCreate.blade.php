@extends('teacher_frontend.layouts.master')
@section('content')
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">

                <!-- Page-Title -->
                <div class="row">
                    <div class="col-sm-12">
                        <h4 class="page-title">新增會議</h4>
                        <h5 class="star">注意！「*」為必填欄位</h5>

                        <form action="#" method="post">
                                <div class="col-lg-10">
                                    <p class="little-title">基本設定</p>
                                    <div class="col-md-6 p-l-45">
                                        <div class="form-group row">
                                            <label for="name" class="col-sm-4 control-label form-title">會議名稱*</label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" id="name" name="name" required="">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="content" class="col-sm-4 control-label form-title">會議摘要*</label>
                                            <div class="col-md-8">
                                                <textarea id="content" name="content" class="form-control" maxlength="225" rows="2"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="datepicker" class="col-sm-4 control-label form-title">會議日期*</label>
                                            <div class="col-md-8" >
                                                <div class="input-group">
                                                    <input type="text" class="form-control" placeholder="mm/dd/yyyy" id="datepicker"　name="meeting_date" required="">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text bg-primary b-0 text-white"><i class="ti-calendar"></i></span>
                                                    </div>
                                                </div><!-- input-group -->
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="meetingStart" class="col-sm-4 control-label form-title">會議時間*</label>
                                            <div class="col-md-8">
                                                    <div class="input-group m-b-5">
                                                        <label class="form-title m-r-10">起 </label>
                                                        <input id="timepicker-start" type="text" class="form-control" name="meeting_start" required="">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text bg-primary text-white"><i class="zmdi zmdi-time"></i></span>
                                                        </div>
                                                    </div><!-- input-group -->
                                                    <div class="input-group">
                                                        <label class="form-title m-r-10">迄 </label>
                                                        <input id="timepicker-end" type="text" class="form-control" name="meeting_end" required="">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text bg-primary text-white"><i class="zmdi zmdi-time"></i></span>
                                                        </div>
                                                    </div><!-- input-group -->
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="meetingStart" class="col-sm-4 control-label form-title">繳交報告期限*</label>
                                            <div class="col-md-8">
                                                <div class="input-group m-b-5">
                                                    <input type="text" class="form-control" placeholder="mm/dd/yyyy" id="datepicker-upload" name="upload_date" required="">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text bg-primary b-0 text-white"><i class="ti-calendar"></i></span>
                                                    </div>
                                                </div><!-- input-group -->
                                                <div class="input-group">
                                                    <input id="timepicker-upload" type="text" class="form-control" name="upload_time">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text bg-primary text-white"><i class="zmdi zmdi-time"></i></span>
                                                    </div>
                                                </div><!-- input-group -->
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-10">
                                    <p class="little-title">報告組別 *</p>
                                    <div class="col-md-6 p-l-45">

                                    </div>
                                </div>

                            <div class="col-lg-10">
                                <p class="little-title">比重設定</p>
                                <div class="col-md-6 p-l-45">
                                    <div class="form-group row">
                                        <label for="TS" class="col-sm-4 control-label form-title">教師評分比重*</label>
                                        <div class="form-group m-r-10">
                                            <input type="text" required class="form-control" id="TS" name="TS" style="text-align: center" required="">
                                        </div>
                                        <label for="member_limit" class="form-title m-r-10">%</label>
                                    </div>
                                    <div class="form-group row">
                                        <label for="PA" class="col-sm-4 control-label form-title">學生互評比重*</label>
                                        <div class="form-group m-r-10">
                                            <input type="text" required class="form-control" id="PA" name="PA" style="text-align: center" required="">
                                        </div>
                                        <label for="member_limit" class="form-title m-r-10">%</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-10">
                                <p class="little-title">加分條件 *</p>
                                <h5><b>評分組別</b></h5>
                                <div class="col-sm-10 p-l-45">
                                    <div class="form-group row">
                                        <label for="team_limit" class="col-sm-4 control-label form-title m-r-10">最多評分</label>
                                        <div class="form-group m-r-10">
                                            <input type="text" class="form-control" id="team_limit" name="team_limit" style="text-align: center" required="">
                                        </div>
                                        <label for="team_limit" class="form-title m-r-10">份</label>
                                    </div>
                                    <div class="form-group row">
                                        <label for="team_bonus" class="col-sm-4 control-label form-title m-r-10">每評分一份 +</label>
                                        <div class="form-group m-r-10">
                                            <input type="text" class="form-control" id="team_bonus" name="team_bonus" style="text-align: center" required="">
                                        </div>
                                        <label for="team_bonus" class="form-title m-r-10">分</label>
                                    </div>
                                </div>
                                <h5><b>評分組員</b></h5>
                                <div class="col-sm-10 p-l-45">
                                    <div class="form-group row">
                                        <label for="member_limit" class="col-sm-4 control-label form-title m-r-10">最多評分</label>
                                        <div class="form-group m-r-10">
                                            <input type="text" class="form-control" id="member_limit" name="member_limit" style="text-align: center" required="">
                                        </div>
                                        <label for="member_limit" class="form-title m-r-10">份</label>
                                    </div>
                                    <div class="form-group row">
                                        <label for="member_bonus" class="col-sm-4 control-label form-title m-r-10">每評分一份 +</label>
                                        <div class="form-group m-r-10">
                                            <input type="text" class="form-control" id="member_bonus" name="member_bonus" style="text-align: center" required="">
                                        </div>
                                        <label for="member_bonus" class="form-title m-r-10">分</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 m-t-30" align="center">
                                <button type="submit" class="btn btn-success waves-effect waves-light button-font">確認</button>
                            </div><!-- end col -->
                        </form>
                </div>
            </div> <!-- container-fluid -->
        </div> <!-- content -->
    </div>
@endsection
@section('title','新增會議')

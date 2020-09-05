@extends('student_frontend.layouts.master')
@section('content')
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">
                <!-- Page-Title -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="btn-group m-b-10">
                            <h4 class="page-title">會議詳情</h4>
                        </div>
                        <div class="col-md-10">
                            <div class="table-responsive col-md-10">
                                <p class="info-title">基本設定</p>
                                <div class="p-l-20 p-b-10">
                                    <table class='table table-bordered'>
                                        <tbody>
                                        <tr><td>會議名稱</td><td>{{$meeting['name']}}</td></tr>
                                        <tr><td>會議日期</td><td>{{$meeting['meeting_date']}}</td></tr>
                                        <tr><td>會議時間</td><td>{{date("H : i",strtotime($meeting['meeting_start'])). " ~ " .date("H : i",strtotime($meeting['meeting_end']))}}</td></tr>
                                        <tr><td>會議摘要</td><td>{{$meeting['content']}}</td></tr>
                                        <tr><td width="35%">繳交報告時間</td><td>{{$meeting['upload_date'].'　'.date("H : i",strtotime($meeting['upload_time']))}}</td></tr>
                                        </tbody>
                                    </table>
                                </div>
                                <p class="info-title">報告組別</p>
                                <div class="p-l-20 p-b-10">
                                    <label class="form-title">{{$meeting['report_team']}}</label>
                                </div>
                                <p class="info-title">比重設定</p>
                                <div class="p-l-20 p-b-10">
                                    <table class='table table-bordered'>
                                        <tbody>
                                        <tr><td width="35%">學生互評比重</td><td>{{$meeting['PA']}} %</td></tr>
                                        <tr><td>教師評分比重</td><td>{{$meeting['TS']}} %</td></tr>
                                        </tbody>
                                    </table>
                                </div>
                                <p class="info-title">加分條件</p>
                                <div class="p-l-20">
                                    <table class='table table-bordered'>
                                        <tbody>
                                        <tr><td width="35%">評分組別</td><td>最多評分 {{$meeting['team_limit']}} 份 ； 每評分一份 + {{$meeting['team_bonus']}} 分</td></tr>
                                        <tr><td>評分組員</td><td>最多評分 {{$meeting['member_limit']}} 份 ； 每評分一份 + {{$meeting['member_bonus']}} 分</td></tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- container-fluid -->
        </div> <!-- content -->
    </div>
@endsection
@section('title','會議詳情')

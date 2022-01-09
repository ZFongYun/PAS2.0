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
                                        <tr><td width='15%'>新增學年期</td><td>{{$meeting['year']}} {{$meeting['semester']== 0 ? '上學期' : '下學期'}}</td></tr>
                                        <tr><td>會議日期</td><td>{{$meeting['meeting_date']}}</td></tr>
                                        <tr><td>會議時間</td><td>{{date("H : i",strtotime($meeting['meeting_start'])). " ~ " .date("H : i",strtotime($meeting['meeting_end']))}}</td></tr>
                                        <tr><td>會議摘要</td><td>{{$meeting['content']}}</td></tr>
                                        <tr><td width="35%">繳交報告時間</td><td>{{$meeting['upload_date'].'　'.date("H : i",strtotime($meeting['upload_time']))}}</td></tr>
                                        </tbody>
                                    </table>
                                </div>
                                <p class="info-title">報告組別</p>
                                <div class="p-l-20 p-b-10">
                                    <table class='table table-bordered'>
                                        <tbody><tr>
                                            @foreach($meeting_team as $item)
                                                <td>{{$item->name}}</td>
                                            @endforeach
                                        </tr></tbody>
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

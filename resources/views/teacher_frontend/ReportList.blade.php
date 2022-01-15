@extends('teacher_frontend.layouts.master')
@section('content')
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">
                <!-- Page-Title -->
                <div class="row">
                    <div class="col-sm-12">
                        <h4 class="page-title">報告下載</h4>
                        <div class="table-responsive">
                            <table class="table table-hover m-0" style="text-align: center">
                                <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th>會議名稱</th>
                                    <th>繳交期限</th>
                                    <th>已繳交</th>
                                </tr>
                                </thead>
                                <tbody>
                                @for($i = 0; $i<$meeting_length; $i++)
                                    <tr>
                                        <td>{{$meeting[$i]['id']}}</td>
                                        <td><a href="{{route('ReportList.show',$meeting[$i]['id'])}}">{{$meeting[$i]['name']}}</a></td>
                                        <td>{{$meeting[$i]['upload_date'].'　'.date("H : i",strtotime($meeting[$i]['upload_time']))}}</td>
                                        <td>{{$report_list[$i]}}</td>
                                    </tr>
                                @endfor
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div> <!-- container-fluid -->
        </div> <!-- content -->
    </div>
@endsection
@section('title','報告下載')

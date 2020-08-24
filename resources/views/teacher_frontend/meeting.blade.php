@extends('teacher_frontend.layouts.master')
@section('content')
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">

                <!-- Page-Title -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="btn-group m-b-20">
                            <h4 class="page-title">會議管理</h4>
                            <a href="{{route('meeting.create')}}" class="btn btn-primary waves-effect m-l-15 waves-light m-b-5">新增會議</a>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover m-0">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>會議名稱</th>
                                    <th>會議日期</th>
                                    <th>進入評分</th>
                                    <th>詳情</th>
                                    <th>刪除</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($meeting as $row)
                                    <tr>
                                        <td>{{$row['id']}}</td>
                                        <td>{{$row['name']}}</td>
                                        <td>{{$row['meeting_date']."　".date("H : i",strtotime($row['meeting_start'])). " ~ " .date("H : i",strtotime($row['meeting_end']))}}</td>
                                        <td><a href="#" class="btn btn-icon waves-effect waves-light btn-primary"><i class="fa fa-sign-in"></i></a></td>
                                        <td><a href="#" class="btn btn-icon waves-effect waves-light btn-info"><i class="fa fa-edit (alias)"></i></a></td>
{{--                                        <form action="{{route('ImportStudent.destroy',$row['id'])}}" method="post">--}}
{{--                                            <td><button type="submit" class="btn btn-icon waves-effect waves-light btn-danger m-b-5" onclick="return(confirm('是否刪除此筆資料？'))"> <i class="fa fa-remove"></i> </button></td>--}}
{{--                                            <input type="hidden" name="_method" value="DELETE">--}}
{{--                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">--}}
{{--                                        </form>--}}
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>



            </div> <!-- container-fluid -->

        </div> <!-- content -->



    </div>
@endsection
@section('title','會議管理')

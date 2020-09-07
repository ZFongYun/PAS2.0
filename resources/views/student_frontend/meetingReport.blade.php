@extends('student_frontend.layouts.master')
@section('content')
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">
                <!-- Page-Title -->
                <div class="row">
                    <div class="col-sm-12">
                        <h4 class="page-title">繳交報告</h4>
                        <div class="col-auto" align="center">
                            <h4>{{$meeting['name']}}</h4>
                            <p>繳交報告時間：{{$meeting['upload_date'].'　'.date("H : i",strtotime($meeting['upload_time']))}}</p>
                            @if($messageSuccess = Session::get('success'))
                                <div class="alert alert-success alert-block" style="color: #1c7430">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    {{ $messageSuccess }}
                                </div>
                            @endif

                            @if($report == null)
                                <p>未上傳</p>
                                <form action="{{route('StuMeeting.upload',$meeting['id'])}}" method="post" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <input name="file" type="file" accept=".pptx,.rar,.zip" value="">
                                    <div class="form-group" {{ $errors->has('file') ? 'has-error' : '' }}>
                                        <label for="file"></label>
                                        <span class="text-danger"> {{ $errors->first('file') }}</span>
                                    </div>
                                    <p class="m-t-15">*上傳格式：pptx、zip、rar<br>
                                        *檔案大小限制；1GB</p>
                                    <button type="submit" class="btn waves-effect btn-rounded waves-light btn-success">上傳</button>
                                </form>
                            @else
                                <p>已上傳</p>
                                <form action="{{route('StuMeeting.report_edit',$meeting['id'])}}" method="post" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <input name="file" type="file" accept=".pptx,.rar,.zip" value="">
                                    <div class="form-group" {{ $errors->has('file') ? 'has-error' : '' }}>
                                        <label for="file"></label>
                                        <span class="text-danger"> {{ $errors->first('file') }}</span>
                                    </div>
                                    <p class="m-t-15">*上傳格式：pptx、zip、rar<br>
                                        *檔案大小限制；1GB</p>
                                    <button type="submit" class="btn waves-effect btn-rounded waves-light btn-success">重新上傳</button>
                                    <p style="color: #3ec845;font-size: 20px">已繳交！</p>
                                    <p>繳交時間：{{date("Y-m-d H:i:s",strtotime($report[0]['created_at']))}}</p>
                                    <p>{{$report[0]['file_name']}}</p>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div> <!-- container-fluid -->
        </div> <!-- content -->
    </div>
@endsection
@section('title','繳交報告')

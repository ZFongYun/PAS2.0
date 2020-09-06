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
                            <form action="{{route('StuMeeting.upload',$meeting['id'])}}" method="post" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <input name="file" type="file" accept=".pptx,.rar,.zip" value="">
                                <div class="form-group" {{ $errors->has('file') ? 'has-error' : '' }}>
                                    <label for="filename"></label>
                                    <span class="text-danger"> {{ $errors->first('file') }}</span>
                                </div>
                                <p class="m-t-15" style="color: #0044cc;font-size: 12px">*上傳格式：pptx、zip、rar<br>
                                    *檔案大小限制；1GB</p>
                                <button type="submit" class="btn waves-effect btn-rounded waves-light btn-success">上傳</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div> <!-- container-fluid -->
        </div> <!-- content -->
    </div>
@endsection
@section('title','繳交報告')

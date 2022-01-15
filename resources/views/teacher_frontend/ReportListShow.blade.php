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
                            <h4 class="page-title">已交名單</h4>
                            <a href="{{route('ReportList.downloadALL',$meeting_id)}}" class="btn btn-primary waves-effect m-l-15 waves-light m-b-5">全部下載</a>
                        </div>
                        @if($messageWarning = Session::get('warning'))
                            <div class="alert alert-warning alert-block" style="color: #f0b360">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                {{ $messageWarning }}
                            </div>
                        @endif
                        <div class="table-responsive">
                            <table class="table table-hover m-0">
                                <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th>小組名稱</th>
                                    <th>標題</th>
                                    <th>繳交日期</th>
                                    <th>下載</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($report as $row)
                                    <tr>
                                        <td>{{$row->id}}</td>
                                        <td>{{$row->name}}</td>
                                        <td>{{$row->file_name}}</td>
                                        <td>{{date("Y-m-d　H:i",strtotime($row->created_at))}}</td>
                                        <td><a href="{{route('ReportList.download',$row->id)}}" class="btn btn-icon waves-effect waves-light btn-primary"><i class="zmdi zmdi-download"></i></a></td>
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
@section('title','已交名單')

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

                    </div>
                </div>



            </div> <!-- container-fluid -->

        </div> <!-- content -->



    </div>
@endsection
@section('title','會議管理')

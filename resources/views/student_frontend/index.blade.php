@extends('student_frontend.layouts.master')
@section('content')
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">

                <!-- Page-Title -->
                <div class="row">
                    <div class="col-sm-12">
                        <h4 class="page-title p-b-10">會議公告</h4>
                        @foreach($bulletin as $row)
                        <div class="col-lg-8">
                            <div class="card card-custom card-border">
                                <div class="card-heading">
                                    <h2 class="card-title text-custom m-0">{{$row['title']}}</h2>
                                    <h4 class="card-title text-dark m-0" style="font-size: 10px">發布日期：{{date("Y/m/d　H : i",strtotime($row['created_at']))}}</h4>
                                </div>
                                <div class="card-body">
                                    <p class="mb-0">
                                        {{$row['content']}}
                                    </p>
                                </div>
                            </div>
                        </div><!-- end col -->
                        @endforeach
                    </div>
                </div>



            </div> <!-- container-fluid -->

        </div> <!-- content -->

    </div>
@endsection
@section('title','首頁')

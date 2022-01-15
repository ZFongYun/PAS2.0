@extends('student_frontend.layouts.master')
@section('content')
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">

                <!-- Page-Title -->
                <div class="row">
                    <div class="col-sm-12">
                        <h4 class="page-title p-b-10">排行榜</h4>
                        <p>目前已加入組別：{{$user_team_name}}</p>
                        <p>成績紀錄日期：{{$score_record_date}}</p>
                        <div class="col-lg-10">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table m-0" style="text-align: center">
                                            <thead>
                                            <tr>
                                                <th>排名</th>
                                                <th>姓名</th>
                                                <th>總得分</th>
                                                <th>=</th>
                                                <th>貢獻度</th>
                                                <th>x</th>
                                                <th>成效分數</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @for($i=0; $i<count($stu_score); $i++)
                                                <tr>
                                                    <td>第{{$i+1}}名</td>
                                                    @if(auth('student')->user()->name == $stu_score[$i]->name)
                                                        <td style="color: crimson; background: yellow">{{$stu_score[$i]->name}}</td>
                                                    @else
                                                        <td>{{$stu_score[$i]->name}}</td>
                                                    @endif
                                                        <td>{{$stu_score[$i]->total}}</td>
                                                    <td></td>
                                                    <td>{{$stu_score[$i]->CV}}</td>
                                                    <td></td>
                                                    <td>{{$stu_score[$i]->EV}}</td>
                                                </tr>
                                            @endfor
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
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

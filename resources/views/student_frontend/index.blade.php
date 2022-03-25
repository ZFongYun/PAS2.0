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
                        @if($message ?? '')
                            <div class="alert alert-danger alert-block" style="color: #EE5959">
                                {{$message}}
                            </div>
                        @else
                            <p>目前已加入組別：{{$user_team_name}}</p>
                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table m-0" style="text-align: center;">
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
                                                    @if(auth('student')->user()->name == $stu_score[$i]->name)
                                                        <tr style="color: #007bff; background: rgb(255,255,128)">
                                                            <td>第{{$i+1}}名</td>
                                                            <td>{{$stu_score[$i]->name}}</td>
                                                            @if($arr != null)
                                                                @if($arr[0] == 0)
                                                                    <td>{{$stu_score[$i]->total}} <span class="text-success">&nbsp;<i class="fa fa-angle-double-up"></i> {{$arr[1]}}分</span></td>
                                                                @elseif($arr[0] == 1)
                                                                    <td>{{$stu_score[$i]->total}} <span class="text-danger">&nbsp;<i class="fa fa-angle-double-down"></i>{{$arr[1]}}分</span></td>
                                                                @else
                                                                    <td>{{$stu_score[$i]->total}} <span class="text-secondary">&nbsp;<i class="fa fa-minus"></i>{{$arr[1]}}分</span></td>
                                                                @endif
                                                            @endif
                                                            <td></td>
                                                            <td>{{$stu_score[$i]->CV}}</td>
                                                            <td></td>
                                                            <td>{{$stu_score[$i]->EV}}</td>
                                                        </tr>
                                                    @else
                                                        <tr>
                                                            <td>第{{$i+1}}名</td>
                                                            <td>{{$stu_score[$i]->name}}</td>
                                                            <td>{{$stu_score[$i]->total}}</td>
                                                            <td></td>
                                                            <td>{{$stu_score[$i]->CV}}</td>
                                                            <td></td>
                                                            <td>{{$stu_score[$i]->EV}}</td>
                                                        </tr>
                                                    @endif
                                                @endfor
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="row" style="margin-top: 13pt; margin-bottom: -10pt;">
                                            <div class="col-6"><p>※備註：總得分滿分500分</p></div>
                                            <div class="col-6"><p style="text-align: right">成績紀錄日期：{{$score_record_date}}</p></div>
                                        </div>
                                        <div style="margin-bottom: -10pt;">
                                            @if($arr != null)
                                                @if($arr[0] == 0)
                                                    <h4 class="text-success">與上次會議所得到的總得分<span style="font-size: 10pt">({{$stu_score_nd[0]->total}})</span>共進步{{$arr[1]}}分，請繼續保持！</h4>
                                                @elseif($arr[0] == 1)
                                                    <h4 class="text-danger">與上次會議所得到的總得分<span style="font-size: 10pt">({{$stu_score_nd[0]->total}})</span>共退步{{$arr[1]}}分，下次再加油！</h4>
                                                @else
                                                    <h4 class="text-secondary">本次與上次的總得分無變動。</h4>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>

                            </div>
                        @endif

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

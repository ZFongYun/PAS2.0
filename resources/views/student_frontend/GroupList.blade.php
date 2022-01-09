@extends('student_frontend.layouts.master')
@section('content')
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">

                <!-- Page-Title -->
                <div class="row">
                    <div class="col-sm-12">
                        <h4 class="page-title">小組專區</h4>
                    </div>
                    @if(isset($warning))
                        <p class="m-l-15 m-t-15" style="color: crimson;font-size: 15px">{{$warning}}</p>
                    @endif

                    @if(isset($stu_team))
                        <div class="col-sm-12">
                            <p style="font-size: 25px">已加入組別：{{$stu_team[0]->name}}</p>
                            <p><h4>組別簡介</h4></p>
                            <p>{{$stu_team[0]->content}}</p>

                            <div class="table-responsive">
                                <p><h4>組員列表</h4></p>
                                <table class="table table-hover m-0">
                                    <thead>
                                    <tr>
                                        <th>學號</th>
                                        <th>姓名</th>
                                        <th>角色</th>
                                        <th>職務</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @for($i=0; $i<$team_member_length; $i++)
                                        <tr>
                                            <td>{{$team_member[$i]['student']['student_id']}}</td>
                                            <td>{{$team_member[$i]['student']['name']}}</td>
                                            @if($team_member[$i]['role']==0)
                                                <td>組長</td>
                                            @elseif($team_member[$i]['role']==1)
                                                <td>組員</td>
                                            @endif
                                            @if($team_member[$i]['position']==0)
                                                <td>企劃</td>
                                            @elseif($team_member[$i]['position']==1)
                                                <td>程式</td>
                                            @elseif($team_member[$i]['position']==2)
                                                <td>美術</td>
                                            @elseif($team_member[$i]['position']==3)
                                                <td>技美</td>
                                            @endif
                                        </tr>
                                        </form>
                                    @endfor
                                    </tbody>
                                </table>
                            </div>
                            @if($stu_team[0]->role == 0)
                                <a href="{{route('StuGroupList.edit',$stu_team[0]->team_id)}}" class="btn waves-effect waves-light btn-warning btn-sm m-t-20" style="height: 30px">編輯</a>
                            @endif
                        </div>

                    @endif
                </div>
            </div> <!-- container-fluid -->
        </div> <!-- content -->
    </div>
@endsection
@section('title','小組專區')

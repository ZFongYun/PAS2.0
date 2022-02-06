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
                            <h4 class="page-title">{{$team[0]['year']}} - {{$team[0]['semester']== 0 ? '上學期' : '下學期'}}  {{$team[0]['name']}}</h4>
                        </div>
                        <h4>組別簡介</h4>
                        <p>{{$team[0]['content']}}</p>

                        <h4>組員</h4>
                        <div class="table-responsive">
                            <table class="table table-hover m-0">
                                <thead>
                                <tr>
                                    <th>學號</th>
                                    <th>姓名</th>
                                    <th>角色</th>
                                    <th>職務</th>
                                    <th width="10%">刪除</th>
                                </tr>
                                </thead>
                                <tbody>
                                @for($i=0; $i<$team_member_length; $i++)
                                    <form action="{{action('GroupListController@destroy_member',$team_member[$i]['student']['id'])}}" method="post">
                                        {{ csrf_field() }}
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
                                            @endif
                                            <input type="hidden" name="team_id" value="{{$team[0]['id']}}" />
                                            <td><button type="submit" class="btn btn-icon waves-effect waves-light btn-danger m-b-5" onclick="return(confirm('是否刪除此筆資料？'))"> <i class="fa fa-remove"></i> </button></td>
                                        </tr>
                                    </form>
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
@section('title','組員列表')

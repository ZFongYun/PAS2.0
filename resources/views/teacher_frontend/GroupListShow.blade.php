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
                            <h4 class="page-title">組員列表</h4>
                        </div>
                        <h4>{{$team_name}}</h4>
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
                                @for($i=0; $i<$student_length; $i++)
                                    <form action="{{action('GroupListController@destroy_member',$student[$i]['id'])}}" method="post">
                                        {{ csrf_field() }}
                                        <tr>
                                            <td>{{$student[$i]['student_id']}}</td>
                                            <td>{{$student[$i]['name']}}</td>
                                            @if($student[$i]['role']==0)
                                                <td>組長</td>
                                            @elseif($student[$i]['role']==1)
                                                <td>組員</td>
                                            @endif
                                            @if($student[$i]['position']==0)
                                                <td>企劃</td>
                                            @elseif($student[$i]['position']==1)
                                                <td>程式</td>
                                            @elseif($student[$i]['position']==2)
                                                <td>美術</td>
                                            @endif
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

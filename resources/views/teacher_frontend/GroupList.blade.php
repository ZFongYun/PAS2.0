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
                            <h4 class="page-title">小組專區</h4>
                            <a href="{{route('GroupList.create')}}" class="btn btn-primary waves-effect m-l-15 waves-light m-b-5">新增組別</a>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover m-0">
                                <thead>
                                <tr>
                                    <th>組別名稱</th>
                                    <th>組長</th>
                                    <th>組員</th>
                                    <th width="10%">加入成員</th>
                                    <th width="10%">編輯</th>
                                    <th width="10%">刪除</th>
                                </tr>
                                </thead>
                                <tbody>
                                @for($i=0; $i<$team_length; $i++)
                                    <tr>
                                        <td><a href="{{route('GroupList.show',$arr_id[0][$i]['id'])}}">{{$arr_team[0][$i]['name']}}</a></td>
                                        <td>{{$arr_leader[$i]}}</td>
                                        <td>{{$arr_member[$i]}}</td>
                                        <td><a href="{{action('GroupListController@plus_page',$arr_id[0][$i]['id'])}}" class="btn btn-icon waves-effect waves-light btn-primary"><i class="fa fa-user-plus"></i></a></td>
                                        <td><a href="{{route('GroupList.edit',$arr_id[0][$i]['id'])}}" class="btn btn-icon waves-effect waves-light btn-info"><i class="fa fa-edit (alias)"></i></a></td>
                                        <form action="{{route('GroupList.destroy',$arr_id[0][$i]['id'])}}" method="post">
                                            <td><button type="submit" class="btn btn-icon waves-effect waves-light btn-danger m-b-5" onclick="return(confirm('是否刪除此筆資料？'))"> <i class="fa fa-remove"></i> </button></td>
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        </form>
                                    </tr>

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
@section('title','小組專區')


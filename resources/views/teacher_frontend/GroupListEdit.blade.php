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
                            <h4 class="page-title">編輯組別</h4>
                        </div>

                        <form method="post" action="{{action('GroupListController@update',$id)}}">
                            <div class="col-lg-10">
                                <div class="form-group row">
                                    <label for="name" class="col-sm-2 control-label form-title" ><span class="text-danger">*</span>組別名稱</label>
                                    <div class="col-md-5" >
                                        <input type="text" class="form-control" id="name" name="name" value="{{$team[0]['name']}}" required="">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="year" class="col-sm-2 control-label form-title" ><span class="text-danger">*</span>新增學年度</label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                            <input type="text" class="form-control m-r-10" id="year" name="year" value="{{$team[0]['year']}}" required="">
                                            <select class="form-control" id="semester" name="semester">
                                                <option value="0" {{$team[0]['semester'] == 0 ? 'selected' : ''}}>上學期</option>
                                                <option value="1" {{$team[0]['semester'] == 1 ? 'selected' : ''}}>下學期</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="content" class="col-md-2 control-label form-title">組別簡介</label>
                                    <div class="col-md-5">
                                        <textarea id="content" name="content" class="form-control" maxlength="225" rows="2">{{$team[0]['content']}}</textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="status" class="col-md-2 control-label form-title"><span class="text-danger">*</span>組別狀態</label>
                                    <div class="col-md-5">
                                        <select class="form-control" id="status" name="status">
                                            <option value="0" {{$team[0]['status'] == 0 ? 'selected' : ''}}>未結束</option>
                                            <option value="1" {{$team[0]['status'] == 1 ? 'selected' : ''}}>已結束</option>
                                        </select>
                                    </div>
                                </div>

                                <p class="form-title"><span class="text-danger">*</span>編輯組員</p>

                                @if($messageWarning = Session::get('warning'))
                                    <div class="alert alert-warning alert-block" style="color: #f0b360">
                                        <button type="button" class="close" data-dismiss="alert">×</button>
                                        {{ $messageWarning }}
                                    </div>
                                @endif

                                @if($messageRepeat = Session::get('repeat'))
                                    <div class="alert alert-danger alert-block" style="color: #EE5959">
                                        <button type="button" class="close" data-dismiss="alert">×</button>
                                        {{ $messageRepeat }}
                                    </div>
                                @endif

                                @if($messageError = Session::get('error'))
                                    <div class="alert alert-danger alert-block" style="color: #EE5959">
                                        <button type="button" class="close" data-dismiss="alert">×</button>
                                        {{ $messageError }}
                                    </div>
                                @endif

                                <div class="table-responsive">
                                    <table class="table table-hover m-0" style="text-align: center">
                                        <thead>
                                        <tr>
                                            <th>學號</th>
                                            <th>姓名</th>
                                            <th>角色</th>
                                            <th>職位</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @for($i=0; $i<$team_member_length; $i++)
                                            <tr>
                                                <td>{{$team_member[$i]['student']['student_id']}}</td>
                                                <td>{{$team_member[$i]['student']['name']}}</td>
                                                <td>
                                                    <select name="role{{$team_member[$i]['id']}}">
                                                        <option value="0" {{$team_member[$i]['role'] == 0 ? 'selected' : ''}}>組長</option>
                                                        <option value="1" {{$team_member[$i]['role'] == 1 ? 'selected' : ''}}>組員</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="position{{$team_member[$i]['id']}}">
                                                        <option value="0" {{$team_member[$i]['position'] == 0 ? 'selected' : ''}}>企劃</option>
                                                        <option value="1" {{$team_member[$i]['position'] == 1 ? 'selected' : ''}}>程式</option>
                                                        <option value="2" {{$team_member[$i]['position'] == 2 ? 'selected' : ''}}>美術</option>
                                                    </select>
                                                    <input type="hidden" name="hidden_id[]" value="{{$team_member[$i]['id']}}" />
                                                </td>
                                            </tr>

                                        @endfor
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="col-lg-10 m-t-30" align="right">
                                <button type="submit" class="btn btn-success waves-effect waves-light button-font">確認</button>
                            </div><!-- end col -->
                            <input type="hidden" name="_method" value="PUT">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        </form>
                    </div>
                </div>

            </div> <!-- container-fluid -->

        </div> <!-- content -->

    </div>

@endsection
@section('title','編輯組別')

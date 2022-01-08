@extends('teacher_frontend.layouts.master')
@section('content')
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">

                <!-- Page-Title -->
                <div class="row">
                    <div class="col-sm-10">
                        <h4 class="page-title">編輯會議</h4>
                        <h5 class="star">注意！「*」為必填欄位</h5>

                        <form action="{{route('meeting.update',$meeting['id'])}}" method="post">
                            {{ csrf_field() }}
                            <p class="little-title">基本設定</p>
                            <div class="col-md-8">
                                <div class="form-group row">
                                    <label for="name" class="col-md-2 control-label form-title"><span class="text-danger">*</span>會議名稱</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" id="name" name="name" required="" value="{{$meeting['name']}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="year" class="col-sm-2 control-label form-title" ><span class="text-danger">*</span>新增學年度</label>
                                    <div class="col-md-8">
                                        <div class="input-group">
                                            <input type="text" class="form-control m-r-10" id="year" name="year" required="" value="{{$meeting['year']}}">
                                            <select class="form-control" id="semester" name="semester">
                                                <option value="0" {{$meeting['semester'] == 0 ? 'selected' : ''}}>上學期</option>
                                                <option value="1" {{$meeting['semester'] == 1 ? 'selected' : ''}}>下學期</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="datepicker" class="col-md-2 control-label form-title"><span class="text-danger">*</span>會議日期</label>
                                    <div class="col-md-8" >
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="yyyy-mm-dd" id="datepicker" name="meeting_date" required="" value="{{$meeting['meeting_date']}}">
                                            <div class="input-group-append">
                                                <span class="input-group-text bg-primary b-0 text-white"><i class="ti-calendar"></i></span>
                                            </div>
                                        </div><!-- input-group -->
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="meetingStart" class="col-md-2 control-label form-title"><span class="text-danger">*</span>會議起止時間</label>
                                    <div class="col-md-8">
                                        <div class="input-group">
                                            <input id="timepicker-start" type="text" class="form-control" name="meeting_start" required="" value="{{$meeting['meeting_start']}}">
                                            <div class="input-group-append">
                                                <span class="input-group-text bg-primary text-white"><i class="zmdi zmdi-time"></i></span>
                                            </div>
                                            <p style="margin-right: 5pt; margin-left: 5pt"> ~ </p>
                                            <input id="timepicker-end" type="text" class="form-control" name="meeting_end" required="" value="{{$meeting['meeting_end']}}">
                                            <div class="input-group-append">
                                                <span class="input-group-text bg-primary text-white"><i class="zmdi zmdi-time"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="content" class="col-md-2 control-label form-title">會議摘要</label>
                                    <div class="col-md-8">
                                        <textarea id="content" name="content" class="form-control" maxlength="225" rows="2">{{$meeting['content']}}</textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="meetingStart" class="col-md-2 control-label form-title"><span class="text-danger">*</span>繳交報告期限</label>
                                    <div class="col-md-8">
                                        <div class="input-group m-b-10">
                                            <input type="text" class="form-control" placeholder="yyyy-mm-dd" id="datepicker-upload" name="upload_date" required="" value="{{$meeting['upload_date']}}">
                                            <div class="input-group-append">
                                                <span class="input-group-text bg-primary b-0 text-white"><i class="ti-calendar"></i></span>
                                            </div>
                                        </div><!-- input-group -->
                                        <div class="input-group">
                                            <input id="timepicker-upload" type="text" class="form-control" name="upload_time" value="{{$meeting['upload_time']}}">
                                            <div class="input-group-append">
                                                <span class="input-group-text bg-primary text-white"><i class="zmdi zmdi-time"></i></span>
                                            </div>
                                        </div><!-- input-group -->
                                    </div>
                                </div>
                            </div>
                            <p class="little-title"><span class="text-danger">*</span>報告組別</p>
                            <div class="col-md-8">
                                <button type="button" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#select-team">選擇</button>
                                <label>已選擇..</label>
                                <span class="m-t-5" id="team"></span>
                                <input type="hidden" id="teamId" name="teamId">
                            </div>

                            <div class="m-t-30" align="right">
                                <button type="submit" class="btn btn-warning waves-effect waves-light button-font">編輯</button>
                            </div><!-- end col -->
                            <input type="hidden" name="_method" value="PUT">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        </form>
                    </div>
                </div> <!-- container-fluid -->
            </div> <!-- content -->
        </div>
        <!-- select modal content -->
        <div id="select-team" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title mt-0" id="myModalLabel">請選擇成員</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table table-hover m-0">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>學年期</th>
                                    <th>組別名稱</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($team as $item)
                                    <tr>
                                        <td><input type="checkbox" class="teamCheckbox" name="team[]" id="{{$item['name']}}" value="{{$item['id']}}"
                                                   @foreach($meeting_team as $row)
                                                        @if($row->team_id == $item['id'])
                                                            checked
                                                        @endif
                                                    @endforeach
                                            ></td>
                                        <td>{{$item['year']}} - {{$item['semester']== 0 ? '1' : '2'}}</td>
                                        <td>{{$item['name']}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="search btn waves-effect waves-light btn-primary" data-dismiss="modal">確認</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <script type="text/javascript">
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $( document ).ready(function() {
                var team = '';
                var checkedValue = [];
                var inputElements = document.getElementsByClassName('teamCheckbox');
                for(var i=0; inputElements[i]; ++i){
                    if(inputElements[i].checked){
                        checkedValue.push(inputElements[i].value);
                        team += '<label>'+ inputElements[i].id + '／' + '</label>';
                    }
                }
                $('#team').html(team);
                $('#teamId').val(checkedValue);
            });

            $(document).on('click', '.search', function() {
                var team = '';
                var checkedValue = [];
                var inputElements = document.getElementsByClassName('teamCheckbox');
                for(var i=0; inputElements[i]; ++i){
                    if(inputElements[i].checked){
                        checkedValue.push(inputElements[i].value);
                        team += '<label>'+ inputElements[i].id + '／' + '</label>';
                    }
                }
                $('#team').html(team);
                $('#teamId').val(checkedValue);
            });
        </script>
@endsection
@section('title','編輯會議')

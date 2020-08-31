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
                            <h4 class="page-title">[ 評分 ] {{$meeting['name']}}</h4>
                        </div>
                        <div class="form-group row">
                            <label for="public" class="col-sm-1 control-label form-title">選擇評分組別</label>
                            <div class="col-md-5">
                                <select name="team" id="team" class="form-control" onchange="check()">
                                    <option default>請選擇</option>
                                    @for($i=1;$i<count($report_team_arr);$i++)
                                    <option value="{{$report_team_arr[$i]}}">{{$report_team_arr[$i]}}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <p class="form-title" id="team_title" style="display: none">◎ 評分組別</p>
                        <div class="table-responsive">
                            <table class="table table-hover m-0" id="team_table" style="display: none">
                                <thead>
                                <tr>
                                    <th>組別名稱</th>
                                    <th>分數</th>
                                    <th width="10%"></th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>

                        <p class="form-title p-t-10" id="member_title" style="display: none">◎ 評分組員</p>
                        <div class="table-responsive">
                            <table class="table table-hover m-0" id="member_table" style="display: none">
                                <thead>
                                <tr>
                                    <th>學號</th>
                                    <th>姓名</th>
                                    <th>職務</th>
                                    <th>分數</th>
                                    <th width="10%"></th>
                                </tr>
                                </thead>
                                <tbody id="stu">

                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>

                <!-- 評分組別Modal -->
                <div id="ScoringTeamModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title mt-0" id="myModalLabel">進行評分</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="title" class="control-label">得分</label>
                                            <select name="score_team" id="score_team" class="form-control">
                                                <option value="100">100</option>
                                                <option value="90">90</option>
                                                <option value="80">80</option>
                                                <option value="70">70</option>
                                                <option value="60">60</option>
                                                <option value="50">50</option>
                                                <option value="40">40</option>
                                                <option value="30">30</option>
                                                <option value="20">20</option>
                                                <option value="10">10</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group no-margin">
                                            <label for="feedback_team" class="control-label">回饋</label>
                                            <textarea class="form-control autogrow" id="feedback_team" name="feedback_team" style="overflow: hidden; word-wrap: break-word; resize: horizontal; height: 104px;"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success waves-effect waves-light"  id="team_send">送出</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->

                <!-- 編輯組別Modal -->
                <div id="EditTeamModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title mt-0" id="myModalLabel">編輯評分</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="title" class="control-label">得分</label>
                                            <select name="edit_score_team" id="edit_score_team" class="form-control">
                                                <option value="100">100</option>
                                                <option value="90">90</option>
                                                <option value="80">80</option>
                                                <option value="70">70</option>
                                                <option value="60">60</option>
                                                <option value="50">50</option>
                                                <option value="40">40</option>
                                                <option value="30">30</option>
                                                <option value="20">20</option>
                                                <option value="10">10</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group no-margin">
                                            <label for="edit_feedback_team" class="control-label">回饋</label>
                                            <textarea class="form-control autogrow" id="edit_feedback_team" name="edit_feedback_team" style="overflow: hidden; word-wrap: break-word; resize: horizontal; height: 104px;"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success waves-effect waves-light"  id="team_edit">送出</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->

                <!-- 評分組員Modal -->
                <div id="ScoringStudentModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title mt-0" id="myModalLabel">評分組員</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="title" class="control-label">得分</label>
                                            <select name="score_stu" id="score_stu" class="form-control">
                                                <option value="100">100</option>
                                                <option value="90">90</option>
                                                <option value="80">80</option>
                                                <option value="70">70</option>
                                                <option value="60">60</option>
                                                <option value="50">50</option>
                                                <option value="40">40</option>
                                                <option value="30">30</option>
                                                <option value="20">20</option>
                                                <option value="10">10</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group no-margin">
                                            <label for="feedback_stu" class="control-label">回饋</label>
                                            <textarea class="form-control autogrow" id="feedback_stu" name="feedback_stu" style="overflow: hidden; word-wrap: break-word; resize: horizontal; height: 104px;"></textarea>
                                            <input type="hidden" name="score_stu_id" id="score_stu_id">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success waves-effect waves-light"  id="stu_send">送出</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->

                <!-- 編輯組員Modal -->
                <div id="EditStuModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title mt-0" id="myModalLabel">編輯評分</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="title" class="control-label">得分</label>
                                            <select name="edit_score_stu" id="edit_score_stu" class="form-control">
                                                <option value="100">100</option>
                                                <option value="90">90</option>
                                                <option value="80">80</option>
                                                <option value="70">70</option>
                                                <option value="60">60</option>
                                                <option value="50">50</option>
                                                <option value="40">40</option>
                                                <option value="30">30</option>
                                                <option value="20">20</option>
                                                <option value="10">10</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group no-margin">
                                            <label for="edit_feedback_stu" class="control-label">回饋</label>
                                            <textarea class="form-control autogrow" id="edit_feedback_stu" name="edit_feedback_stu" style="overflow: hidden; word-wrap: break-word; resize: horizontal; height: 104px;"></textarea>
                                            <input type="hidden" name="edit_stu_id" id="edit_stu_id">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success waves-effect waves-light"  id="stu_edit">送出</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->

            </div> <!-- container-fluid -->

    </div>
        <script type="text/javascript">
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var check=function(){
                var html = '';
                var html_stu = '';
                var team = $("#team").val();
                $(document).ready(function() {
                    $.ajax({
                        type:'POST',
                        url:'/meeting/score',
                        data:{team:team,
                            meeting_id: {{$meeting['id']}},
                            _token: '{{csrf_token()}}'},
                        dataType: 'json',
                        success: function(data) {
                            if (data == 'null'){
                                $('#team_table').hide();
                                $('#team_title').hide();
                                $('#member_table').hide();
                                $('#member_title').hide();
                                html = '';
                                html_stu = '';
                            }else {
                                if (data[1] == '0'){
                                    $('#team_table').show();
                                    $('#team_title').show();
                                    html += '<tr>';
                                    html += '<td>'+data[0]+'</td>';
                                    html += '<td>'+data[1]+'</td>';
                                    html += '<td>'+'<button class="btn btn-primary waves-effect waves-light m-l-10 button-font" data-toggle="modal" data-target="#ScoringTeamModal">評分</button>'+'</td></tr>';
                                    $('tbody').html(html);
                                }else {
                                    $('#team_table').show();
                                    $('#team_title').show();
                                    html += '<tr>';
                                    html += '<td>'+data[0]+'</td>';
                                    html += '<td>'+data[1][0]['point']+'</td>';
                                    html += '<td><button class="edit_team_modal btn btn-warning waves-effect waves-light m-l-10 button-font" id="edit_team_modal" data-toggle="modal" data-target="#EditTeamModal" data-feedback="'+data[1][0]['feedback']+'" data-point="'+data[1][0]['point']+'" data-team="'+data[0]+'">編輯</button>'+'</td></tr>';
                                    $('tbody').html(html);
                                }
                                $('#member_table').show();
                                $('#member_title').show();
                                for (var i=3; i<data.length; i+=2){
                                    if (data[i] == '0'){
                                        html_stu += '<tr>';
                                        html_stu += '<td>'+data[i-1]['student_id']+'</td>';
                                        html_stu += '<td>'+data[i-1]['name']+'</td>';
                                        if (data[i-1]['position'] == 0){
                                            html_stu += '<td>'+'企劃'+'</td>'
                                        }else if(data[i-1]['position'] == 1){
                                            html_stu += '<td>'+'程式'+'</td>'
                                        }else{
                                            html_stu += '<td>'+'美術'+'</td>'
                                        }
                                        html_stu += '<td>'+data[i]+'</td>';
                                        html_stu += '<td>'+'<button class="score_stu_modal btn btn-primary waves-effect waves-light m-l-10 button-font" data-toggle="modal" data-target="#ScoringStudentModal" data-sid="'+data[i-1]['id']+'">評分</button>'+'</td></tr>';
                                        $('#stu').html(html_stu);
                                    }else {
                                        html_stu += '<tr>';
                                        html_stu += '<td>'+data[i-1]['student_id']+'</td>';
                                        html_stu += '<td>'+data[i-1]['name']+'</td>';
                                        if (data[i-1]['position'] == 0){
                                            html_stu += '<td>'+'企劃'+'</td>'
                                        }else if(data[i-1]['position'] == 1){
                                            html_stu += '<td>'+'程式'+'</td>'
                                        }else{
                                            html_stu += '<td>'+'美術'+'</td>'
                                        }
                                        html_stu += '<td>'+data[i][0]['point']+'</td>';
                                        html_stu += '<td><button class="edit_stu_modal btn btn-warning waves-effect waves-light m-l-10 button-font" data-toggle="modal" data-target="#EditStuModal" data-sid="'+data[i-1]['id']+'" data-point="'+data[i][0]['point']+'" data-feedback="'+data[i][0]['feedback']+'">編輯</button>'+'</td></tr>';
                                        $('#stu').html(html_stu);
                                    }
                                }
                            }

                        },
                        error: function (){
                            alert('加入失敗');
                        }
                    })
                });
            }

            $('#team_send').click(function () {
                //評分組別
                var score = $("#score_team").val();
                var feedback = $("#feedback_team").val();
                var team = $("#team").val();
                $(document).ready(function() {
                    $.ajax({
                        type:'POST',
                        url:'/meeting/scoring_team',
                        data:{team:team,
                            score:score,
                            feedback:feedback,
                            meeting_id: {{$meeting['id']}},
                            _token: '{{csrf_token()}}'},
                        dataType: 'json',
                        success: function(data) {
                            alert(data)
                            $('#ScoringTeamModal').modal('hide')
                            check()
                        },
                        error: function (){
                            alert('評分失敗')
                        }

                    });
                });
            });

            $(document).on('click', '.edit_team_modal', function() {
                //開啟編輯組別modal, 輸入編輯前的值
                $('#edit_feedback_team').val($(this).data('feedback'));
                $('#edit_score_team').val($(this).data('point'));
            });

            $('#team_edit').click(function () {
                //編輯組別
                var score = $("#edit_score_team").val();
                var feedback = $("#edit_feedback_team").val();
                var team = $("#team").val();
                $(document).ready(function() {
                    $.ajax({
                        type:'POST',
                        url:'/meeting/edit_team',
                        data:{team:team,
                            score:score,
                            feedback:feedback,
                            meeting_id: {{$meeting['id']}},
                            _token: '{{csrf_token()}}'},
                        dataType: 'json',
                        success: function(data) {
                            alert(data)
                            $('#EditTeamModal').modal('hide')
                            check()
                        },
                        error: function (){
                            alert('編輯失敗')
                        }
                    });
                });
            });

            $(document).on('click', '.score_stu_modal', function() {
                //開啟編輯組別modal
                $('#score_stu_id').val($(this).data('sid'));
            });

            $('#stu_send').click(function () {
                //評分組員
                var score = $("#score_stu").val();
                var feedback = $("#feedback_stu").val();
                var id = $('#score_stu_id').val();
                $(document).ready(function() {
                    $.ajax({
                        type:'POST',
                        url:'/meeting/scoring_stu',
                        data:{id:id,
                            score:score,
                            feedback:feedback,
                            meeting_id: {{$meeting['id']}},
                            _token: '{{csrf_token()}}'},
                        dataType: 'json',
                        success: function(data) {
                            alert(data)
                            $('#ScoringStudentModal').modal('hide')
                            check()
                        },
                        error: function (){
                            alert('評分失敗')
                        }
                    });
                });
            });

            $(document).on('click', '.edit_stu_modal', function() {
                //開啟編輯組員modal, 輸入編輯前的值
                $('#edit_score_stu').val($(this).data('point'));
                $('#edit_feedback_stu').val($(this).data('feedback'));
                $('#edit_stu_id').val($(this).data('sid'));
            });

            $('#stu_edit').click(function () {
                //編輯組員
                var score = $("#edit_score_stu").val();
                var feedback = $("#edit_feedback_stu").val();
                var id = $('#edit_stu_id').val();
                $(document).ready(function() {
                    $.ajax({
                        type:'POST',
                        url:'/meeting/edit_stu',
                        data:{id:id,
                            score:score,
                            feedback:feedback,
                            meeting_id: {{$meeting['id']}},
                            _token: '{{csrf_token()}}'},
                        dataType: 'json',
                        success: function(data) {
                            alert(data)
                            $('#EditStuModal').modal('hide')
                            check()
                        },
                        error: function (){
                            alert('編輯失敗')
                        }
                    });
                });
            });

        </script>
@endsection
@section('title','會議評分')

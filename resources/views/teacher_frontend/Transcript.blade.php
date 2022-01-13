@extends('teacher_frontend.layouts.master')
@section('content')
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">

                <!-- Page-Title -->
                <div class="row">
                    <h4 class="page-title">學生成績</h4>
                    <div class="col-12 m-t-10">
                        <form class="form-inline">
                            <div class="form-group m-r-10 col-sm-3">
                                <label for="meeting" class="m-r-10">會議記錄</label>
                                <select class="form-control col-sm-8" id="year" name="year">
                                    <option value="">請選擇</option>
                                    <option value="110-0">110-1</option>
                                    <option value="110-1">110-2</option>
                                    <option value="111-0">111-1</option>
                                    <option value="111-1">111-2</option>
                                </select>
                            </div>
                            <div class="form-group m-r-10 col-sm-3">
                                <label for="team" class="m-r-10">組別</label>
                                <select class="form-control col-sm-8" id="team" name="team">

                                </select>
                            </div>
                            <div class="form-group m-r-10 col-sm-3">
                                <label for="team" class="m-r-10">紀錄</label>
                                <select class="form-control col-sm-8" id="record" name="record">

                                </select>
                            </div>
                            <button type="button" class="search btn btn-primary waves-effect waves-light btn-md">搜尋</button>
                        </form>
                    </div>
                </div>

                <label class="form-title p-t-10" id="date_title"></label><br>

                <div class="row col-12" id="member_title" style="display: none; font-size: 15pt;">
                    <p class="form-title p-t-10 p-r-10"><b>組員個別成績</b></p>
                    <button tabindex="0" class="btn btn-info btn-xs h-25 m-t-10" data-toggle="popover" data-trigger="focus" title="分數計算" data-content="總得分 = 貢獻度 x 成效分數">
                        <i class="fa fa-question-circle"></i>
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table m-0" id="member_table" style="display: none">
                        <thead>
                        <tr>
                            <th>學號</th>
                            <th>姓名</th>
                            <th>貢獻度</th>
                            <th>成效分數</th>
                            <th>總得分</th>
                            <th width="10%"></th>
                        </tr>
                        </thead>
                        <tbody id="member_body">
                        </tbody>
                    </table>
                </div>

            </div> <!-- container-fluid -->
        </div> <!-- content -->
    </div>

    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("#year").change(function(){
            var year = $('#year').val();
            $(document).ready(function() {
                $.ajax({
                    type:'POST',
                    url:'/APS_teacher/Transcript/searchYear',
                    data:{year:year,
                        _token: '{{csrf_token()}}'},
                    success: function(data) {
                        var YearSinner="";
                        for (var i = 0; i < data.length; i++){
                            YearSinner = YearSinner+'<option value='+data[i]['id']+'>'+data[i]['name']+'</option>';
                        }
                        $("#team").html(YearSinner);
                    },
                    error: function (){
                        alert('error')
                    }
                });
            });
        });

        $("#team").change(function(){
            var team = $('#team').val();

            $(document).ready(function() {
                $.ajax({
                    type:'POST',
                    url:'/APS_teacher/Transcript/searchTeam',
                    data:{team:team,
                        _token: '{{csrf_token()}}'},
                    success: function(data) {
                        var TeamSinner="";
                        TeamSinner = TeamSinner+'<option value="0">組別績效排行榜</option>';
                        for (var i = 0; i < data.length; i++){
                            TeamSinner = TeamSinner+'<option value='+data[i]['meeting_id']+'>'+data[i]['name']+'</option>';
                        }
                        $("#record").html(TeamSinner);
                    },
                    error: function (){
                        alert('error')
                    }
                });
            });
        });

        $(document).on('click', '.search', function() {
            var meeting = $('#record').val();
            var team = $('#team').val();
            var html_member = '';
            $(document).ready(function() {
                $.ajax({
                    type:'POST',
                    url:'/APS_teacher/Transcript/search',
                    data:{meeting:meeting,
                        team:team,
                        _token: '{{csrf_token()}}'},
                    dataType: 'json',
                    success: function(data) {

                        if(data[0][0] == ''){
                            alert('無結果');
                            $('#date_title').hide();
                            $('#member_title').hide();
                            $('#member_table').hide();

                        }else {
                            $('#date_title').html('日期　'+data[3]);
                            $('#member_title').show();
                            $('#member_table').show();

                            html_member += '<tr>';
                            for (var i = 0; i < data[0].length; i++) {
                                html_member += '<td>' + data[0][i][0].student_ID + '</td>';
                                html_member += '<td>' + data[0][i][0].name + '</td>';
                                html_member += '<td>' + data[0][i][0].CV + '</td>';
                                html_member += '<td>' + data[0][i][0].EV + '</td>';
                                html_member += '<td>' + data[0][i][0].total + '</td>';
                                html_member += '<td><button class="btn btn-custom type="button" data-toggle="collapse" data-target="#member_feedback' + data[0][i][0].student_ID + '">詳情</button></td></tr>';
                                html_member += '<tr>';
                                html_member += '<td colspan="7" class="hiddenRow"><div class="collapse" id="member_feedback' + data[0][i][0].student_ID + '"><label>' + '成員給予的評論' + '</label>'
                                html_member += '<table class="table"><thead><tr><th>姓名</th><th>貢獻度</th><th>回饋</th></tr></thead><tbody><tr>';
                                if (data[1][i] == '') {
                                    html_member += '<td>-</td>';
                                    html_member += '<td>-</td>';
                                    html_member += '<td>-</td></tr>';
                                } else {
                                    for (var m = 0; m < data[1][i].length; m++) {
                                        html_member += '<td>' + data[1][i][m]['name'] + '</td>';
                                        html_member += '<td>' + data[1][i][m]['CV'] + '</td>';
                                        html_member += '<td>' + data[1][i][m]['feedback'] + '</td></tr>';
                                    }
                                    html_member += '</tbody></table>';
                                }

                                html_member += '<label>' + '同儕給予的評論' + '</label>';
                                html_member += '<table class="table"><thead><tr><th>姓名</th><th>成效分數</th><th>回饋</th></tr></thead><tbody><tr>';
                                if (data[2][i] == '') {
                                    html_member += '<td>-</td>';
                                    html_member += '<td>-</td>';
                                    html_member += '<td>-</td></tr>';
                                } else {
                                    for (var n = 0; n < data[2][i].length; n++) {
                                        html_member += '<td>' + data[2][i][n]['name'] + '</td>';
                                        html_member += '<td>' + data[2][i][n]['EV'] + '</td>';
                                        html_member += '<td>' + data[2][i][n]['feedback'] + '</td></tr>';
                                    }
                                }
                                html_member += '</tbody></table></div></td></tr>';
                            }
                            $('#member_body').html(html_member);
                        }
                    },
                    error: function (){
                        alert('error')
                    }

                });
            });
        });

    </script>
@endsection
@section('title','學生成績')

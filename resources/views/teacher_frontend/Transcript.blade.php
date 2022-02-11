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

                <label class="form-title p-t-10 " id="date_title"></label><br>

                <div class="row col-12" id="member_title" style="display: none; font-size: 15pt;">
{{--                    <p class="form-title p-t-10 p-r-10"><b>組員個別成績</b></p>--}}
                    <h3 class="p-t-10 p-r-10">組員個別成績</h3>
                    <button tabindex="0" class="btn btn-info btn-xs h-25 m-t-10" data-toggle="popover" data-trigger="focus" title="分數計算" data-content="總得分 = 貢獻度 x 成效分數">
                        <i class="fa fa-question-circle"></i>
                    </button>
                </div>

                <div class="table-responsive col-md-8">
                    <table class="table m-0" id="member_table" style="display: none;">
                        <thead>
                        <tr>
                            <th>學號</th>
                            <th>姓名</th>
                            <th>貢獻度</th>
                            <th>成效分數</th>
                            <th>總得分</th>
                            <th width="15%"></th>
                        </tr>
                        </thead>
                        <tbody id="member_body">
                        </tbody>
                    </table>
                </div>

                <div class="alert alert-danger" role="alert" id="danger" style="display: none; width: 60%">
                    未有成績紀錄
                </div>

                <div id="all_grades" style="display: none"></div>

            </div> <!-- container-fluid -->
        </div> <!-- content -->
    </div>

    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // 選擇「學年期」後要做的事情
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
                        check();
                    },
                    error: function (){
                        alert('error')
                    }
                });
            });
        });

        // 選擇「組別」後要做的事情
        $("#team").change(function(){
            var team = $('#team').val();
            $(document).ready(function() {
                $.ajax({
                    type:'POST',
                    url:'/APS_teacher/Transcript/searchTeam',
                    data:{team:team,
                        _token: '{{csrf_token()}}'},
                    success: function(data) {
                        if (data.length == 0){
                            $("#record").html("");
                        }else {
                            var TeamSinner="";
                            TeamSinner = TeamSinner+'<option value="0">組內績效排行榜</option>';
                            for (var i = 0; i < data.length; i++){
                                TeamSinner = TeamSinner+'<option value='+data[i]['meeting_id']+'>'+data[i]['name']+'</option>';
                            }
                            $("#record").html(TeamSinner);
                        }

                    },
                    error: function (){
                        alert('error')
                    }
                });
            });
        });

        // 選擇「組別」後要做的事情
        var check=function(){
            var team = $('#team').val();
            $(document).ready(function() {
                $.ajax({
                    type:'POST',
                    url:'/APS_teacher/Transcript/searchTeam',
                    data:{team:team,
                        _token: '{{csrf_token()}}'},
                    success: function(data) {
                        if (data.length == 0){
                            $("#record").html("");
                        }else {
                            var TeamSinner="";
                            TeamSinner = TeamSinner+'<option value="0">組內績效排行榜</option>';
                            for (var i = 0; i < data.length; i++){
                                TeamSinner = TeamSinner+'<option value='+data[i]['meeting_id']+'>'+data[i]['name']+'</option>';
                            }
                            $("#record").html(TeamSinner);
                        }
                    },
                    error: function (){
                        alert('error')
                    }
                });
            });
        }

        $(document).on('click', '.search', function() {
            var meeting = $('#record').val();
            var team = $('#team').val();
            var html_member = '';
            var html_grades = '';

            if (team == null){
                alert('請選擇組別');
            }else {
                $(document).ready(function() {
                    $.ajax({
                        type:'POST',
                        url:'/APS_teacher/Transcript/search',
                        data:{meeting:meeting,
                            team:team,
                            _token: '{{csrf_token()}}'},
                        dataType: 'json',
                        success: function(data) {

                            // 選擇「組內績效排行榜」
                            if(data[4] == '0'){

                                $('#member_title').hide();
                                $('#member_table').hide();

                                if (data[0] == '未有分數紀錄'){
                                    $('#danger').show();
                                    $('#date_title').hide();
                                    $('#member_title').hide();
                                    $('#member_table').hide();
                                    $('#all_grades').hide();

                                }else{
                                    $('#date_title').hide();
                                    $('#member_title').hide();
                                    $('#member_table').hide();
                                    $('#all_grades').show();

                                    for (var i = 0; i < data[1].length; i++){
                                        html_grades += '<h3 class="p-t-10 p-r-10">組內績效排行榜</h3>'
                                        html_grades += '<p>'+ data[1][i].name +'</p>'
                                        html_grades += '<div class="col-lg-10"><div class="card"><div class="card-body"><div class="table-responsive">'
                                        html_grades += '<table class="table m-0" style="text-align: center">'
                                        html_grades += '<thead> <tr> <th>排名</th> <th>姓名</th> <th>總得分</th> <th>=</th> <th>貢獻度</th> <th>x</th> <th>成效分數</th> </tr> </thead>'
                                        html_grades += '<tbody>'
                                        for (var y = 0; y < data[2][i].length; y++){
                                            var sum = y+1;
                                            html_grades += '<tr> <td>第' + sum + '名</td> <td>' + data[2][i][y].name + '</td> <td>' + data[2][i][y].total + '</td> <td></td> <td>' + data[2][i][y].CV + '</td> <td></td> <td>' + data[2][i][y].EV + '</td> </tr>'
                                        }
                                        html_grades += '</tbody>'
                                        html_grades += '</table>'
                                        html_grades += '</div></div></div></div>'
                                    }
                                    $('#all_grades').html(html_grades);
                                }

                            // 選擇「會議記錄」
                            }else {
                                if(data[0][0] == ''){
                                    alert('無結果');
                                    $('#date_title').hide();
                                    $('#member_title').hide();
                                    $('#member_table').hide();
                                    $('#all_grades').hide();

                                }else {
                                    $('#all_grades').hide();
                                    $('#date_title').html('成績紀錄日期：'+data[3]);
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
                                        html_member += '<td colspan="7" class="hiddenRow"><div class="collapse" id="member_feedback' + data[0][i][0].student_ID + '"><label>' + '組內成員給予的評論' + '</label>'
                                        html_member += '<table class="table"><thead><tr><th width="20%">姓名</th><th width="20%">貢獻度</th><th>回饋</th></tr></thead><tbody><tr>';
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

                                        html_member += '<label>' + '組外成員給予的評論' + '</label>';
                                        html_member += '<table class="table"><thead><tr><th width="20%">姓名</th><th width="20%">成效分數</th><th>回饋</th></tr></thead><tbody><tr>';
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
                            }
                        },
                        error: function (){
                            alert('error')
                        }

                    });
                });
            }
        });

    </script>
@endsection
@section('title','學生成績')

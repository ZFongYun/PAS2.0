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
                            <h4 class="page-title">[ 結算 ] {{$meeting['name']}}</h4>
                        </div>
                        <div class="form-group row">
                            <label for="public" class="col-2 control-label form-title">請選擇結算組別</label>
                            <div class="col-md-5">
                                <select name="team" id="team" class="form-control" onchange="check()">
                                    <option default>請選擇</option>
{{--                                    @for($i=1;$i<count($report_team_arr);$i++)--}}
{{--                                        <option value="{{$report_team_arr[$i]}}">{{$report_team_arr[$i]}}</option>--}}
{{--                                    @endfor--}}
                                    @for($i=0;$i<count($report_team_show);$i++)
                                        <option value="{{$report_team_show[$i][0]['id']}}">{{$report_team_show[$i][0]['name']}}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="alert alert-success" role="alert" id="success" style="display: none; width: 60%">
                            已完成結算。
                        </div>

                        <div class="alert alert-danger" role="alert" id="danger" style="display: none; width: 60%">
                            未完成結算，請點選此 <button type="submit" class="send btn waves-effect waves-light btn-success m-b-10" data-mid="{{$meeting['id']}}">按鈕</button><input type="hidden" id="score_send"> 進行結算。
                        </div>
                    </div>

                    <label class="form-title p-t-10" id="team_title" style="display: none">小組成績</label>
                    <div class="table-responsive">
                        <table class="table m-0" id="team_table" style="display: none">
                            <thead>
                            <tr>
                                <th>組別名稱</th>
                                <th>得分</th>
                                <th>加分</th>
                                <th>總得分</th>
                                <th>平均評分份數</th>
                                <th width="10%"></th>
                            </tr>
                            </thead>
                            <tbody id="team_body">
                            </tbody>
                        </table>
                    </div>

                    <label class="form-title p-t-10" id="member_title" style="display: none">組員成績</label>
                    <div class="table-responsive">
                        <table class="table m-0" id="member_table" style="display: none">
                            <thead>
                            <tr>
                                <th>學號</th>
                                <th>姓名</th>
                                <th>得分</th>
                                <th>加分</th>
                                <th>總得分</th>
                                <th>平均評分份數</th>
                                <th width="10%"></th>
                            </tr>
                            </thead>
                            <tbody id="member_body">
                            </tbody>
                        </table>
                    </div>
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

        var check=function(){
            var html_team = '';
            var html_member = '';
            var team = $("#team").val();
            $(document).ready(function() {
                $.ajax({
                    type:'POST',
                    url:'/grades/search',
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
                            if (data[0] == ''){
                                $('#danger').show();
                                $('#success').hide();
                                $('#team_title').hide();
                                $('#team_table').hide();
                                $('#member_title').hide();
                                $('#member_table').hide();
                            }else {
                                $('#danger').hide();
                                $('#success').show();
                                $('#team_title').show();
                                $('#team_table').show();
                                html_team += '<tr>';
                                html_team += '<td>'+data[0][0]['name']+'</td>';
                                html_team += '<td>'+data[0][0]['score']+'</td>';
                                html_team += '<td>'+data[0][0]['bonus']+'</td>';
                                html_team += '<td>'+data[0][0]['total']+'</td>';
                                html_team += '<td>'+data[0][0]['count']+'</td>';
                                html_team += '<td><button class="btn btn-custom type="button" data-toggle="collapse" data-target="#team_feedback">詳情</button></td></tr>';
                                html_team += '<tr>';
                                html_team += '<td colspan="6" class="hiddenRow"><div class="collapse" id="team_feedback"><label>'+'老師評論'+'</label>';
                                if (data[1] == ''){
                                    html_team += '<table class="table"><thead><tr><th>評分</th><th>回饋</th></tr></thead><tbody><tr><td>-</td><td>-</td></tr></tbody></table>';
                                }else {
                                    html_team += '<table class="table"><thead><tr><th>評分</th><th>回饋</th></tr></thead><tbody><tr><td>'+data[1][0]['point']+'</td><td>'+data[1][0]['feedback']+'</td></tr></tbody></table>';
                                }
                                html_team += '<label>'+'其他同學給的評論'+'</label>' + '<table class="table"><thead><tr><th>姓名</th><th>評分</th><th>回饋</th></tr></thead><tbody><tr>';
                                if (data[2] == ''){
                                    html_team += '<td>-</td>';
                                    html_team += '<td>-</td>';
                                    html_team += '<td>-</td></tr>';
                                }else {
                                    for (var i = 0; i<data[2].length; i++){
                                        html_team += '<td>'+data[2][i]['name']+'</td>';
                                        html_team += '<td>'+data[2][i]['point']+'</td>';
                                        html_team += '<td>'+data[2][i]['feedback']+'</td></tr>';
                                    }
                                }
                                html_team += '</tbody></table></div></td></tr>';
                                $('#team_body').html(html_team);

                                $('#member_title').show();
                                $('#member_table').show();
                                for (var j = 0; j<data[3].length; j++) {
                                    if (data[3][j] == ''){
                                        html_member += '<tr>';
                                        html_member += '<td>-</td>';
                                        html_member += '<td>-</td>';
                                        html_member += '<td>-</td>';
                                        html_member += '<td>-</td>';
                                        html_member += '<td>-</td>';
                                        html_member += '<td>-</td></tr>';
                                        $('#member_body').html(html_member);
                                    }else {
                                        html_member += '<tr>';
                                        html_member += '<td>' + data[3][j][0]['student_ID'] + '</td>';
                                        html_member += '<td>' + data[3][j][0]['name'] + '</td>';
                                        html_member += '<td>' + data[3][j][0]['score'] + '</td>';
                                        html_member += '<td>' + data[3][j][0]['bonus'] + '</td>';
                                        html_member += '<td>' + data[3][j][0]['total'] + '</td>';
                                        html_member += '<td>' + data[3][j][0]['count'] + '</td>';
                                        html_member += '<td><button class="btn btn-custom type="button" data-toggle="collapse" data-target="#member_feedback' + data[3][j][0]['student_id'] + '">詳情</button></td></tr>';
                                        html_member += '<tr>';
                                        html_member += '<td colspan="7" class="hiddenRow"><div class="collapse" id="member_feedback' + data[3][j][0]['student_id'] + '"><label>' + '老師評論' + '</label>'
                                        if (data[4][j] == '') {
                                            html_member += '<table class="table"><thead><tr><th>評分</th><th>回饋</th></tr></thead><tbody><tr><td>-</td><td>-</td></tr></tbody></table>'
                                        } else {
                                            html_member += '<table class="table"><thead><tr><th>評分</th><th>回饋</th></tr></thead><tbody><tr><td>' + data[4][j][0]['point'] + '</td><td>' + data[4][j][0]['feedback'] + '</td></tr></tbody></table>'
                                        }
                                        html_member += '<label>' + '其他同學給的評論' + '</label>';
                                        html_member += '<table class="table"><thead><tr><th>姓名</th><th>評分</th><th>回饋</th></tr></thead><tbody><tr>';
                                        if (data[5][j] == '') {
                                            html_member += '<td>-</td>';
                                            html_member += '<td>-</td>';
                                            html_member += '<td>-</td></tr>';
                                        } else {
                                            for (var n = 0; n < data[5][j].length; n++) {
                                                html_member += '<td>' + data[5][j][n]['name'] + '</td>';
                                                html_member += '<td>' + data[5][j][n]['point'] + '</td>';
                                                html_member += '<td>' + data[5][j][n]['feedback'] + '</td></tr>';
                                            }
                                        }
                                        html_member += '</tbody></table></div></td></tr>';
                                    }
                                    $('#member_body').html(html_member);
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

        $(document).on('click', '.send', function() {
            $('#score_send').val($(this).data('mid'));
            var meeting_id = $("#score_send").val();
            var team = $("#team").val();
            $(document).ready(function() {
                $.ajax({
                    type:'POST',
                    url:'/grades/score',
                    data:{meeting_id:meeting_id,
                        team:team,
                        _token: '{{csrf_token()}}'},
                    success: function(data) {
                        alert(data)
                        check()
                    },
                    error: function (){
                        alert('結算失敗')
                    }
                });
            });
        });
    </script>
@endsection
@section('title','結算成績')

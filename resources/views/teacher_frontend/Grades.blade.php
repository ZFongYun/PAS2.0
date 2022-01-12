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
                                    @foreach($meeting_team as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
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

                    <p class="form-title p-t-10 col-12" id="member_title" style="display: none; font-size: 15pt"><b>組員個別成績</b></p>
                    <div class="table-responsive col-md-8">
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
            var html_member = '';
            var team = $("#team").val();
            $(document).ready(function() {
                $.ajax({
                    type:'POST',
                    url:'/APS_teacher/meeting/search',
                    data:{team:team,
                        meeting_id: {{$meeting['id']}},
                        _token: '{{csrf_token()}}'},
                    dataType: 'json',
                    success: function(data) {
                        if (data == 'null'){
                            $('#danger').hide();
                            $('#success').hide();
                            $('#member_table').hide();
                            $('#member_title').hide();
                            html_member = '';

                        }else {
                            if(data == '未結算'){
                                $('#danger').show();
                                $('#success').hide();
                                $('#member_table').hide();
                                $('#member_title').hide();

                            }else {
                                $('#danger').hide();
                                $('#success').show();
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

                        }
                    },
                    error: function (){
                        alert('加入失敗');
                    }
                })
            });
        }

        $(document).on('click', '.send', function() {
            // $('#score_send').val($(this).data('mid'));
            var meeting_id = {{$meeting['id']}};
            var team = $("#team").val();
            $(document).ready(function() {
                $.ajax({
                    type:'POST',
                    url:'/APS_teacher/meeting/score',
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

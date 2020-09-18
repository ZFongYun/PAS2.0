@extends('teacher_frontend.layouts.master')
@section('content')
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">

                <!-- Page-Title -->
                    <div class="col-sm-12">
                        <h4 class="page-title">學生成績</h4>
                            <div class="col-sm-12 m-t-10">
                                <form class="form-inline">
                                    <div class="form-group m-r-10 col-sm-3">
                                        <label for="meeting" class="m-r-10">會議記錄</label>
                                        <select class="form-control col-sm-8" id="meeting" name="meeting">
                                            @foreach($meeting as $row_meeting)
                                                <option value="{{$row_meeting['id']}}">{{$row_meeting['name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group m-r-10 col-sm-3">
                                        <label for="team" class="m-r-10">組別</label>
                                        <select class="form-control col-sm-8" id="team" name="team">
                                            @foreach($team as $row_team)
                                                <option value="{{$row_team['id']}}">{{$row_team['name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <button type="button" class="search btn btn-primary waves-effect waves-light btn-md">搜尋</button>
                                </form>
                            </div>
                    </div>
                    <label class="form-title p-t-10" id="date_title"></label><br>
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


            </div> <!-- container-fluid -->
        </div> <!-- content -->
    </div>

    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).on('click', '.search', function() {
            var meeting = $('#meeting').val();
            var team = $('#team').val();
            var html_team = '';
            var html_member = '';
            $(document).ready(function() {
                $.ajax({
                    type:'POST',
                    url:'/Transcript/search',
                    data:{meeting:meeting,
                        team:team,
                        _token: '{{csrf_token()}}'},
                    success: function(data) {
                        console.log(data)
                        $('#date_title').html('日期　'+data[0]);
                        $('#team_title').show();
                        $('#team_table').show();
                        html_team += '<tr>';
                        html_team += '<td>'+data[1]+'</td>';
                        html_team += '<td>'+data[2][0]['score']+'</td>';
                        html_team += '<td>'+data[2][0]['bonus']+'</td>';
                        html_team += '<td>'+data[2][0]['total']+'</td>';
                        html_team += '<td>'+data[2][0]['count']+'</td>';
                        html_team += '<td><button class="btn btn-custom type="button" data-toggle="collapse" data-target="#team_feedback">詳情</button></td></tr>';
                        html_team += '<tr>';
                        html_team += '<td colspan="6" class="hiddenRow"><div class="collapse" id="team_feedback"><label>'+'老師評論'+'</label>' +
                            '<table class="table"><thead><tr><th>評分</th><th>回饋</th></tr></thead><tbody><tr><td>'+data[3][0]['point']+'</td><td>'+data[3][0]['feedback']+'</td></tr></tbody></table>' +
                            '<label>'+'其他同學給的評論'+'</label>' +
                            '<table class="table"><thead><tr><th>姓名</th><th>評分</th><th>回饋</th></tr></thead><tbody><tr>';
                        for (var i = 0; i<data[4].length; i++){
                            html_team += '<td>'+data[4][i]['name']+'</td>';
                            html_team += '<td>'+data[4][i]['point']+'</td>';
                            html_team += '<td>'+data[4][i]['feedback']+'</td></tr>';
                        }
                        html_team += '</tbody></table></div></td></tr>';
                        $('#team_body').html(html_team);

                        $('#member_title').show();
                        $('#member_table').show();
                        for (var j = 0; j<data[5].length; j++){
                            html_member += '<tr>';
                            html_member += '<td>'+ data[5][j][0]['student_ID'] +'</td>';
                            html_member += '<td>'+ data[5][j][0]['name'] +'</td>';
                            html_member += '<td>'+ data[5][j][0]['score'] +'</td>';
                            html_member += '<td>'+ data[5][j][0]['bonus'] +'</td>';
                            html_member += '<td>'+ data[5][j][0]['total'] +'</td>';
                            html_member += '<td>'+ data[5][j][0]['count'] +'</td>';
                            html_member += '<td><button class="btn btn-custom type="button" data-toggle="collapse" data-target="#member_feedback'+data[5][j][0]['student_id']+'">詳情</button></td></tr>';
                            html_member += '<tr>';
                            html_member += '<td colspan="7" class="hiddenRow"><div class="collapse" id="member_feedback'+data[5][j][0]['student_id']+'"><label>'+'老師評論'+'</label>'
                            html_member += '<table class="table"><thead><tr><th>評分</th><th>回饋</th></tr></thead><tbody><tr><td>'+data[6][j][0]['point']+'</td><td>'+data[6][j][0]['feedback']+'</td></tr></tbody></table>'
                            html_member += '<label>'+'其他同學給的評論'+'</label>';
                            html_member += '<table class="table"><thead><tr><th>姓名</th><th>評分</th><th>回饋</th></tr></thead><tbody><tr>';
                            for (var n = 0; n<data[7][j].length; n++){
                                html_member += '<td>'+data[7][j][n]['name']+'</td>';
                                html_member += '<td>'+data[7][j][n]['point']+'</td>';
                                html_member += '<td>'+data[7][j][n]['feedback']+'</td></tr>';
                            }
                            html_member += '</tbody></table></div></td></tr>';
                        }
                        $('#member_body').html(html_member);

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

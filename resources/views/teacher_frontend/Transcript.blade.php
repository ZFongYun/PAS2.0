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
                        <table class="table table-hover m-0" id="team_table" style="display: none">
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
            $(document).ready(function() {
                $.ajax({
                    type:'POST',
                    url:'/Transcript/search',
                    data:{meeting:meeting,
                        team:team,
                        _token: '{{csrf_token()}}'},
                    success: function(data) {
                        $('#date_title').html('日期　'+data[0]);
                        $('#team_title').show();
                        $('#team_table').show();
                        html_team += '<tr>';
                        html_team += '<td>'+data[1]+'</td>';
                        html_team += '<td>'+data[2][0]['score']+'</td>';
                        html_team += '<td>'+data[2][0]['bonus']+'</td>';
                        html_team += '<td>'+data[2][0]['total']+'</td>';
                        html_team += '<td>'+data[2][0]['count']+'</td>';
                        html_team += '<td><button class="btn btn-custom type="button" data-toggle="collapse" data-target="#demo1">詳情</button></td></tr>';
                        html_team += '<tr>';
                        html_team += '<td colspan="6" class="hiddenRow"><div class="collapse" id="demo1"><label>'+'老師評論'+'</label>' +
                            '<table class="table"><thead><tr><th>評分</th><th>回饋</th></tr></thead><tbody><tr><th>'+data[3][0]['point']+'</th><th>'+data[3][0]['feedback']+'</th></tr></tbody></table>' +
                            '<label>'+'其他同學給的評論'+'</label>' +
                            '<table class="table"><thead><tr><th>姓名</th><th>評分</th><th>回饋</th></tr></thead><tbody><tr>';
                        for (var i = 0; i<data[5]; i++){
                            html_team += '<td>'+data[6][i][0]['name']+'</td>';
                            html_team += '<td>'+data[4][i]['point']+'</td>';
                            html_team += '<td>'+data[4][i]['feedback']+'</td></tr>';
                        }
                        html_team += '</div></td></tr>';
                        $('#team_body').html(html_team);

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

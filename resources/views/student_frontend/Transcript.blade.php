@extends('student_frontend.layouts.master')
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
                                <label for="choose" class="m-r-10">小組/個人</label>
                                <select class="form-control col-sm-8" id="choose" name="choose">
                                    <option value="0">小組</option>
                                    <option value="1">個人</option>
                                </select>
                            </div>
                            <button type="button" class="search btn btn-primary waves-effect waves-light btn-md">搜尋</button>
                        </form>
                    </div>
                </div>
                <label class="form-title p-t-10" id="date_title"></label><br>
                <label class="form-title p-t-10" id="team_title" style="display: none">小組得分結果</label>
                <div class="table-responsive">
                    <table class="table m-0" id="team_table" style="display: none">
                        <thead>
                        <tr>
                            <th>得分</th>
                            <th>加分</th>
                            <th>總得分</th>
                        </tr>
                        </thead>
                        <tbody id="team_body">
                        </tbody>
                    </table>
                </div>

                <label class="form-title p-t-10" id="prof_feedback_title" style="display: none">老師評論</label>
                <div class="table-responsive">
                    <table class="table m-0" id="prof_feedback_table" style="display: none">
                        <thead>
                        <tr>
                            <th>評分</th>
                            <th>回饋</th>
                        </tr>
                        </thead>
                        <tbody id="prof_feedback_body">
                        </tbody>
                    </table>
                </div>

                <label class="form-title p-t-10" id="stu_feedback_title" style="display: none">其他同學給的評論</label>
                <div class="table-responsive">
                    <table class="table m-0" id="stu_feedback_table" style="display: none">
                        <thead>
                        <tr>
                            <th>評分</th>
                            <th>回饋</th>
                        </tr>
                        </thead>
                        <tbody id="stu_feedback_body">
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
            var choose = $('#choose').val();
            var html_team = '';
            var html_prof_feedback = '';
            var html_stu_feedback = '';
            $(document).ready(function() {
                $.ajax({
                    type:'POST',
                    url:'/StuTranscript/stu_search',
                    data:{meeting:meeting,
                        choose:choose,
                        _token: '{{csrf_token()}}'},
                    success: function(data) {
                        console.log(data)
                        $('#date_title').html('日期　'+data[0]);
                        $('#team_title').show();
                        $('#team_table').show();
                        html_team += '<tr>';
                        html_team += '<td>'+data[1][0]['score']+'</td>';
                        html_team += '<td>'+data[1][0]['bonus']+'</td>';
                        html_team += '<td>'+data[1][0]['total']+'</td></tr>';
                        $('#team_body').html(html_team);

                        $('#prof_feedback_title').show();
                        $('#prof_feedback_table').show();
                        html_prof_feedback += '<tr>';
                        html_prof_feedback += '<td>'+data[2][0]['point']+'</td>';
                        html_prof_feedback += '<td>'+data[2][0]['feedback']+'</td></tr>';
                        $('#prof_feedback_body').html(html_prof_feedback);

                        $('#stu_feedback_title').show();
                        $('#stu_feedback_table').show();
                        html_stu_feedback += '<tr>';
                        for (var i = 0; i < data[3].length; i++){
                            html_stu_feedback += '<td>'+data[3][i]['point']+'</td>';
                            html_stu_feedback += '<td>'+data[3][i]['feedback']+'</td></tr>';
                        }
                        $('#stu_feedback_body').html(html_stu_feedback);

                    },
                    error: function (){
                        alert('error')
                    }

                });
            });
        });

    </script>
@endsection
@section('title','查詢成績')

@extends('student_frontend.layouts.master')
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

                <div class="row col-12" id="score_title" style="display: none; font-size: 15pt;">
                    <p class="form-title p-t-10 p-r-10"><b>個人評分結果</b></p>
                    <button tabindex="0" class="btn btn-info btn-xs h-25 m-t-10" data-toggle="popover" data-trigger="focus" title="分數計算" data-content="總得分 = 貢獻度 x 成效分數">
                        <i class="fa fa-question-circle"></i>
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table m-0" id="score_table" style="display: none">
                        <thead>
                        <tr>
                            <th>學號</th>
                            <th>姓名</th>
                            <th>貢獻度</th>
                            <th>成效分數</th>
                            <th>總得分</th>
                        </tr>
                        </thead>
                        <tbody id="score_body">
                        </tbody>
                    </table>
                </div>

                <label class="form-title p-t-10" id="member_feedback_title" style="display: none"><b>組內成員回饋</b></label>
                <div class="table-responsive">
                    <table class="table m-0" id="member_feedback_table" style="display: none">
                        <thead>
                        <tr>
                            <th>貢獻度</th>
                            <th>回饋</th>
                        </tr>
                        </thead>
                        <tbody id="member_feedback_body">
                        </tbody>
                    </table>
                </div>

                <label class="form-title p-t-10" id="stu_feedback_title" style="display: none"><b>同儕回饋</b></label>
                <div class="table-responsive">
                    <table class="table m-0" id="stu_feedback_table" style="display: none">
                        <thead>
                        <tr>
                            <th>成效分數</th>
                            <th>回饋</th>
                        </tr>
                        </thead>
                        <tbody id="stu_feedback_body">
                        </tbody>
                    </table>
                </div>

                <canvas id="chart" width="600" height="300" style="display: none;"></canvas>

            </div> <!-- container-fluid -->
        </div> <!-- content -->
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // 選擇「學年期」要做的事情
        $("#year").change(function(){
            var year = $('#year').val();
            $(document).ready(function() {
                $.ajax({
                    type:'POST',
                    url:'/APS_student/Transcript/searchYearStu',
                    data:{year:year,
                        _token: '{{csrf_token()}}'},
                    success: function(data) {
                        var YearSinner="";
                        for (var i = 0; i < data.length; i++){
                            YearSinner = YearSinner+'<option value='+data[i].team_id+'>'+data[i].name+'</option>';
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

        // 選擇「組別」要做的事情
        $("#team").change(function(){
            var team = $('#team').val();
            $(document).ready(function() {
                $.ajax({
                    type:'POST',
                    url:'/APS_student/Transcript/searchTeam',
                    data:{team:team,
                        _token: '{{csrf_token()}}'},
                    success: function(data) {
                        if (data.length == 0){
                            $("#record").html("");
                        }else {
                            var TeamSinner="";
                            TeamSinner = TeamSinner+'<option value="0">組別績效排行榜</option>';
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

        var check=function(){
            var team = $('#team').val();
            $(document).ready(function() {
                $.ajax({
                    type:'POST',
                    url:'/APS_student/Transcript/searchTeam',
                    data:{team:team,
                        _token: '{{csrf_token()}}'},
                    success: function(data) {
                        if (data.length == 0){
                            $("#record").html("");
                        }else {
                            var TeamSinner="";
                            TeamSinner = TeamSinner+'<option value="0">組別績效排行榜</option>';
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

        // 畫布宣告
        var ctx = document.getElementById('chart');

        // 畫布設定
        var chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [],
                datasets: [{
                    label: '總得分',
                    data: [],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    x: {
                        display: true,
                        title: {
                            display: true,
                            text: '姓名',
                            font: {
                                size: 18,
                                style: 'italic',
                                lineHeight: 1.2,
                            },
                            padding: {top: 20, left: 0, right: 0, bottom: 0}
                        }
                    },
                    y: {
                        display: true,
                        title: {
                            display: true,
                            text: '總得分',
                            font: {
                                size: 18,
                                style: 'italic',
                                lineHeight: 1.2
                            },
                            padding: {top: 30, left: 0, right: 0, bottom: 0}
                        }
                    }
                },
                plugins: {
                    title: {
                        display: true,
                        text: '組別績效排行榜',
                        font: {
                            size: 25,
                            weight: 'bold',
                        },
                        padding: {
                            top: 10,
                            bottom: 30
                        }
                    },
                },
            }
        });

        $(document).on('click', '.search', function() {
            var meeting = $('#record').val();
            var team = $('#team').val();

            var html_score = '';
            var html_member_feedback = '';
            var html_stu_feedback = '';

            if (team == null){
                alert('請選擇組別')
            }else {
                $(document).ready(function() {
                    $.ajax({
                        type:'POST',
                        url:'/APS_student/Transcript/stu_search',
                        data:{meeting:meeting,
                            team:team,
                            _token: '{{csrf_token()}}'},
                        success: function(data) {

                            // 選擇「組別績效排行榜」
                            if(data[4] == '0'){

                                $('#score_title').hide();
                                $('#score_table').hide();
                                $('#chart').show();

                                $('#date_title').html('成績紀錄日期：'+data[3]+' ~ '+data[2]);

                                // 清空遺留的資料
                                chart.data.labels = [];
                                chart.data.datasets[0].data = [];

                                // 更新資料
                                for (var i = 0; i < data[1].length; i++) {
                                    chart.data.labels.push(data[1][i].name);
                                    chart.data.datasets.forEach((dataset) => {
                                        dataset.data.push(data[0][i]);
                                    });
                                }
                                chart.update();

                                // 選擇「會議記錄」
                            }else {
                                if(data[0][0] == ''){
                                    alert('無結果');
                                    $('#date_title').hide();
                                    $('#score_title').hide();
                                    $('#score_table').hide();

                                }else {
                                    $('#date_title').html('成績紀錄日期：'+data[3]);
                                    $('#score_title').show();
                                    $('#score_table').show();
                                    $('#chart').hide();

                                    html_score += '<tr>';
                                    html_score += '<td>'+data[0][0].student_ID+'</td>';
                                    html_score += '<td>'+data[0][0].name+'</td>';
                                    html_score += '<td>'+data[0][0].CV+'</td>';
                                    html_score += '<td>' + data[0][0].EV + '</td>';
                                    html_score += '<td>' + data[0][0].total + '</td></tr>';
                                    $('#score_body').html(html_score);

                                    $('#member_feedback_title').show();
                                    $('#member_feedback_table').show();
                                    if (data[2] == ''){
                                        html_member_feedback += '<tr>';
                                        html_member_feedback += '<td>-</td>';
                                        html_member_feedback += '<td>-</td></tr>';
                                        $('#member_feedback_body').html(html_member_feedback);
                                    }else {
                                        html_member_feedback += '<tr>';
                                        for (var j = 0; j < data[2].length; j++){
                                            html_member_feedback += '<td>'+data[2][j].CV+'</td>';
                                            html_member_feedback += '<td>'+data[2][j].feedback+'</td></tr>';
                                        }
                                        $('#member_feedback_body').html(html_member_feedback);
                                    }

                                    $('#stu_feedback_title').show();
                                    $('#stu_feedback_table').show();
                                    if (data[3] == ''){
                                        html_stu_feedback += '<tr>';
                                        html_stu_feedback += '<td>-</td>';
                                        html_stu_feedback += '<td>-</td></tr>';
                                        $('#stu_feedback_body').html(html_stu_feedback);
                                    }else {
                                        html_stu_feedback += '<tr>';
                                        for (var i = 0; i < data[1].length; i++){
                                            html_stu_feedback += '<td>'+data[1][i].EV+'</td>';
                                            html_stu_feedback += '<td>'+data[1][i].feedback+'</td></tr>';
                                        }
                                        $('#stu_feedback_body').html(html_stu_feedback);
                                    }
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
@section('title','查詢成績')

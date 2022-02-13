@extends('student_frontend.layouts.master')
@section('content')
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">

                <!-- Page-Title -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="btn-group m-b-20">
                            <h4 class="page-title">[ 互評 ] {{$meeting['name']}}</h4>
                        </div>

                        <div class="form-group row">
                            <label for="public" class="col-sm-2 control-label form-title">選擇評分組別</label>
                            <div class="col-md-5">
                                <select name="team" id="team" class="form-control" onchange="check()">
                                    <option default>請選擇</option>
                                    @for($i=0;$i<count($meeting_team);$i++)
                                        <option value="{{$meeting_team[$i]->id}}">{{$meeting_team[$i]->name}}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>

                        {{--組外的表現--}}
                        <div id="peer_part" style="display: none">
                            <h4 class="p-t-10 ">◎ 評分<span style="color: red">組外</span>成員的表現 </h4>
                            <div class="table-responsive col-md-6">
                                <table class="table table-hover m-0" id="peer_table">
                                    <thead>
                                    <tr>
                                        <th>職務</th>
                                        <th>分數</th>
                                    </tr>
                                    </thead>
                                    <tbody id="peer">

                                    </tbody>
                                </table>
                            </div>
                            <h4 class="p-t-10 ">◎ 綜合評語</h4>
                            <div class="col-md-6">
                                <textarea class="form-control autogrow" id="feedback_peer" name="feedback_peer" style="overflow: scroll; word-wrap: break-word; resize: horizontal; height: 150px;"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary waves-effect waves-light m-2" id="peer_send" style="display: none">送出</button>
                            <button type="submit" class="btn btn-warning waves-effect waves-light m-2" id="peer_edit" style="display: none">編輯</button>
                        </div>

                        {{--組內的貢獻度--}}
                        <div id="member_part" style="display: none">
                            <h4 class="p-t-10">◎ 評分<span style="color: red">組內</span>成員的貢獻度</h4>
                            <button class="btn btn-primary m-2" type="button" data-toggle="collapse" data-target="#CV_Instruction" aria-expanded="false" aria-controls="CV_Instruction">
                                貢獻度說明
                            </button>
                            <div class="collapse" id="CV_Instruction">
                                <div class="col-7 card card-body well">
                                    <div class="table-responsive">
                                        <table class="table m-0">
                                            <thead>
                                            <tr>
                                                <th width="15%">表現</th>
                                                <th>說明</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>5</td>
                                                <td>全程專注，並積極達成任務，對小組貢獻度達80%以上</td>
                                            </tr>
                                            <tr>
                                                <td>4</td>
                                                <td>大部分時間專注，能達成任務，對小組貢獻度達70%-80%以上</td>
                                            </tr>
                                            <tr>
                                                <td>3</td>
                                                <td>大部分時間專注，能達成任務，對小組貢獻度達60%-70%以上</td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td>達成部分任務、對小組貢獻度達40%-60%</td>
                                            </tr>
                                            <tr>
                                                <td>1</td>
                                                <td>達成部分任務、對小組貢獻度達40%以下</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive col-md-6">
                                <table class="table table-hover m-0" id="member_table">
                                    <thead>
                                    <tr>
                                        <th>姓名</th>
                                        <th>分數</th>
                                    </tr>
                                    </thead>
                                    <tbody id="member">

                                    </tbody>
                                </table>
                            </div>
                            <h4 class="p-t-10 ">◎ 綜合評語</h4>
                            <div class="col-md-6">
                                <textarea class="form-control autogrow" id="feedback_member" name="feedback_member" style="overflow: scroll; word-wrap: break-word; resize: horizontal; height: 150px;"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary waves-effect waves-light m-2" id="member_send" style="display: none">送出</button>
                            <button type="submit" class="btn btn-warning waves-effect waves-light m-2" id="member_edit" style="display: none">編輯</button>
                        </div>
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

        var meeting = "{{$meeting ['meeting_date']}}" + " " + "{{$meeting ['meeting_end']}}";
        var interval = setInterval(function(){
            var today = new Date();
            var current = today.getFullYear()+"-"+(today.getMonth()+1)+"-"+today.getDate()+" "+today.getHours()+":"+today.getMinutes()+":"+today.getSeconds();
            if(Date.parse(meeting) < Date.parse(current)){
                clearInterval(interval);
                alert("今天會議結束囉~!");
                window.location.href='/APS_student/meeting';
            }
        }, 2000);

        var check=function(){
            var html_peer = '';
            var html_member = '';
            var team = $("#team").val();
            $(document).ready(function() {
                $.ajax({
                    type:'POST',
                    url:'/APS_student/meeting/score',
                    data:{team:team,
                        meeting_id: {{$meeting['id']}},
                        _token: '{{csrf_token()}}'},
                    dataType: 'json',
                    success: function(data) {
                        if (data == 'null'){
                            $('#member_part').hide();
                            $('#peer_part').hide();
                            html_peer = '';
                            html_member = '';
                        }else {
                            if (data[1] === '0'){
                                // 使用者跟評分組別"同組"

                                $('#peer_part').hide();
                                $('#member_part').show();

                                cv_id = []; //儲存被評分組員的id

                                if (data[2] === '0'){
                                    // 未有評分紀錄
                                    for(var i=3; i<data.length; i+=2){
                                        html_member += '<tr>';
                                        html_member += '<td>'+data[i]['name']+'</td>';
                                        html_member += '<td><select id="CV'+data[i]['student_id']+'" name="CV"><option value="5">5</option><option value="4">4</option><option value="3">3</option><option value="2">2</option><option value="1">1</option> </select></td>';
                                        html_member += '</tr>';
                                        $('#member').html(html_member);

                                        cv_id.push(data[i]['student_id']);
                                    }
                                    $('#member_send').show();
                                    $('#member_edit').hide();

                                }else {
                                    // 有評分紀錄
                                    for(var i=3; i<data.length; i+=2){
                                        html_member += '<tr>';
                                        html_member += '<td>'+data[i]['name']+'</td>';
                                        html_member += '<td><select id="CV'+data[i]['student_id']+'" name="CV">';
                                        if(data[i+1][0]['CV']==='5'){
                                            html_member += '<option value="5" selected>5</option>'
                                        }else {
                                            html_member += '<option value="5">5</option>'
                                        }
                                        if (data[i+1][0]['CV']==='4'){
                                            html_member += '<option value="4" selected>4</option>'
                                        }else {
                                            html_member += '<option value="4">4</option>'
                                        }
                                        if (data[i+1][0]['CV']==='3'){
                                            html_member += '<option value="3" selected>3</option>'
                                        }else {
                                            html_member += '<option value="3">3</option>'
                                        }
                                        if (data[i+1][0]['CV']==='2'){
                                            html_member += '<option value="2" selected>2</option>'
                                        }else {
                                            html_member += '<option value="2">2</option>'
                                        }
                                        if (data[i+1][0]['CV']==='1'){
                                            html_member += '<option value="1" selected>1</option></select></td>'
                                        }else {
                                            html_member += '<option value="1">1</option></select></td>'
                                        }
                                        html_member += '</tr>';
                                        $('#member').html(html_member);
                                        $('#feedback_member').val(data[i+1][0]['feedback']);

                                        cv_id.push(data[i]['student_id']);
                                    }

                                    $('#member_send').hide();
                                    $('#member_edit').show();
                                }
                            }else {
                                // 使用者跟評分組別"不同組"

                                $('#member_part').hide();
                                $('#peer_part').show();

                                if (data[2] === '0'){
                                    // 未有評分紀錄
                                    html_peer += '<tr>';
                                    html_peer += '<td>企劃</td>';
                                    html_peer += '<td><select id="EV0" name="EV"><option value="100">100</option><option value="90">90</option><option value="80">80</option><option value="70">70</option><option value="60">60</option><option value="50">50</option><option value="40">40</option><option value="30">30</option><option value="20">20</option><option value="10">10</option></select></td>';
                                    html_peer += '</tr>';
                                    html_peer += '<tr>';
                                    html_peer += '<td>程式</td>';
                                    html_peer += '<td><select id="EV1" name="EV"><option value="100">100</option><option value="90">90</option><option value="80">80</option><option value="70">70</option><option value="60">60</option><option value="50">50</option><option value="40">40</option><option value="30">30</option><option value="20">20</option><option value="10">10</option></select></td>';
                                    html_peer += '</tr>';
                                    html_peer += '<tr>';
                                    html_peer += '<td>美術</td>';
                                    html_peer += '<td><select id="EV2" name="EV"><option value="100">100</option><option value="90">90</option><option value="80">80</option><option value="70">70</option><option value="60">60</option><option value="50">50</option><option value="40">40</option><option value="30">30</option><option value="20">20</option><option value="10">10</option></select></td>';
                                    html_peer += '</tr>';
                                    $('#peer').html(html_peer);
                                    $('#feedback_peer').val('');

                                    $('#peer_send').show();
                                    $('#peer_edit').hide();
                                }else {
                                    // 有評分紀錄
                                    html_peer += '<tr>';
                                    html_peer += '<td>企劃</td>';
                                    html_peer += '<td><select id="EV0" name="EV"><option value="100">100</option><option value="90">90</option><option value="80">80</option><option value="70">70</option><option value="60">60</option><option value="50">50</option><option value="40">40</option><option value="30">30</option><option value="20">20</option><option value="10">10</option></select></td>';
                                    html_peer += '</tr>';
                                    html_peer += '<tr>';
                                    html_peer += '<td>程式</td>';
                                    html_peer += '<td><select id="EV1" name="EV"><option value="100">100</option><option value="90">90</option><option value="80">80</option><option value="70">70</option><option value="60">60</option><option value="50">50</option><option value="40">40</option><option value="30">30</option><option value="20">20</option><option value="10">10</option></select></td>';
                                    html_peer += '</tr>';
                                    html_peer += '<tr>';
                                    html_peer += '<td>美術</td>';
                                    html_peer += '<td><select id="EV2" name="EV"><option value="100">100</option><option value="90">90</option><option value="80">80</option><option value="70">70</option><option value="60">60</option><option value="50">50</option><option value="40">40</option><option value="30">30</option><option value="20">20</option><option value="10">10</option></select></td>';
                                    html_peer += '</tr>';
                                    $('#peer').html(html_peer);
                                    $('#feedback_peer').val(data[3][0]['feedback']);

                                    for(var i=0; i < 3; i++)
                                    {
                                        if(data[i+3][0]['EV'] === 100) {
                                            document.getElementById("EV"+i).selectedIndex = 0;
                                        }else if(data[i+3][0]['EV'] === '90'){
                                            document.getElementById("EV"+i).selectedIndex = 1;
                                        }else if(data[i+3][0]['EV'] === '80'){
                                            document.getElementById("EV"+i).selectedIndex = 2;
                                        }else if(data[i+3][0]['EV'] === '70'){
                                            document.getElementById("EV"+i).selectedIndex = 3;
                                        }else if(data[i+3][0]['EV'] === '60'){
                                            document.getElementById("EV"+i).selectedIndex = 4;
                                        }else if(data[i+3][0]['EV'] === '50'){
                                            document.getElementById("EV"+i).selectedIndex = 5;
                                        }else if(data[i+3][0]['EV'] === '40'){
                                            document.getElementById("EV"+i).selectedIndex = 6;
                                        }else if(data[i+3][0]['EV'] === '30'){
                                            document.getElementById("EV"+i).selectedIndex = 7;
                                        }else if(data[i+3][0]['EV'] === '20'){
                                            document.getElementById("EV"+i).selectedIndex = 8;
                                        }else if(data[i+3][0]['EV'] === '10'){
                                            document.getElementById("EV"+i).selectedIndex = 9;
                                        }
                                    }

                                    $('#peer_send').hide();
                                    $('#peer_edit').show();
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

        $('#peer_send').click(function () {
            //評分同儕
            var team = $("#team").val();
            var score = [];
            for(var i=0; i<3; i+=1){
                score.push($('#EV'+i).val())
            }
            var feedback = $("#feedback_peer").val();
            $(document).ready(function() {
                $.ajax({
                    type:'POST',
                    url:'/APS_student/meeting/scoring_stu',
                    data:{team:team,
                        score:score,
                        feedback:feedback,
                        meeting_id: {{$meeting['id']}},
                        _token: '{{csrf_token()}}'},
                    dataType: 'json',
                    success: function(data) {
                        alert(data)
                        check()
                    },
                    error: function (){
                        alert('評分失敗')
                    }
                });
            });
        });

        $('#peer_edit').click(function () {
            //編輯同儕
            var team = $("#team").val();
            var score = [];
            for(var i=0; i<3; i+=1){
                score.push($('#EV'+i).val())
            }
            var feedback = $("#feedback_peer").val();
            $(document).ready(function() {
                $.ajax({
                    type:'POST',
                    url:'/APS_student/meeting/edit_stu',
                    data:{team:team,
                        score:score,
                        feedback:feedback,
                        meeting_id: {{$meeting['id']}},
                        _token: '{{csrf_token()}}'},
                    dataType: 'json',
                    success: function(data) {
                        alert(data)
                        check()
                    },
                    error: function (){
                        alert('編輯失敗')
                    }
                });
            });
        });

        $('#member_send').click(function () {
            //評分組員
            var score = [];
            for(var i=0; i<cv_id.length; i+=1){
                score.push($('#CV'+cv_id[i]).val())
            }
            var feedback = $("#feedback_member").val();
            $(document).ready(function() {
                $.ajax({
                    type:'POST',
                    url:'/APS_student/meeting/scoring_member',
                    data:{cv_id:cv_id,
                        score:score,
                        feedback:feedback,
                        meeting_id: {{$meeting['id']}},
                        _token: '{{csrf_token()}}'},
                    dataType: 'json',
                    success: function(data) {
                        alert(data)
                        check()
                    },
                    error: function (){
                        alert('評分失敗')
                    }
                });
            });
        });

        $('#member_edit').click(function () {
            //編輯組員
            var score = [];
            for(var i=0; i<cv_id.length; i+=1){
                score.push($('#CV'+cv_id[i]).val())
            }
            var feedback = $("#feedback_member").val();
            $(document).ready(function() {
                $.ajax({
                    type:'POST',
                    url:'/APS_student/meeting/edit_member',
                    data:{cv_id:cv_id,
                        score:score,
                        feedback:feedback,
                        meeting_id: {{$meeting['id']}},
                        _token: '{{csrf_token()}}'},
                    dataType: 'json',
                    success: function(data) {
                        alert(data)
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
@section('title','互評')

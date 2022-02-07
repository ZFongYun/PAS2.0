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
                            <label for="public" class="col-sm-1 control-label form-title">選擇評分組別</label>
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
                        </div>
                    </div>
                </div>

                <!-- 評分同儕表現Modal -->
{{--                <div id="ScoringStudentModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">--}}
{{--                    <div class="modal-dialog">--}}
{{--                        <div class="modal-content">--}}
{{--                            <div class="modal-header">--}}
{{--                                <h4 class="modal-title mt-0" id="myModalLabel">評分同儕表現</h4>--}}
{{--                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
{{--                                    <span aria-hidden="true">&times;</span>--}}
{{--                                </button>--}}
{{--                            </div>--}}
{{--                            <div class="modal-body">--}}
{{--                                <div class="row">--}}
{{--                                    <div class="col-md-12">--}}
{{--                                        <div class="form-group">--}}
{{--                                            <label for="title" class="control-label">得分</label>--}}
{{--                                            <select name="score_stu" id="score_stu" class="form-control">--}}
{{--                                                <option value="100">100</option>--}}
{{--                                                <option value="90">90</option>--}}
{{--                                                <option value="80">80</option>--}}
{{--                                                <option value="70">70</option>--}}
{{--                                                <option value="60">60</option>--}}
{{--                                                <option value="50">50</option>--}}
{{--                                                <option value="40">40</option>--}}
{{--                                                <option value="30">30</option>--}}
{{--                                                <option value="20">20</option>--}}
{{--                                                <option value="10">10</option>--}}
{{--                                            </select>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="row">--}}
{{--                                    <div class="col-md-12">--}}
{{--                                        <div class="form-group no-margin">--}}
{{--                                            <label for="feedback_stu" class="control-label">回饋</label>--}}
{{--                                            <select class="form-control select2" style="margin-bottom: 10px" onchange="feedback_stu(this.value)">--}}
{{--                                                <option value="default">---請選擇回饋範例---</option>--}}
{{--                                                <optgroup label="企劃">--}}
{{--                                                    <option value="報告時臺風穩健">報告時臺風穩健</option>--}}
{{--                                                    <option value="報告內容有條理且清楚展示進度">報告內容有條理且清楚展示進度</option>--}}
{{--                                                    <option value="工作進度規劃明確且適宜">工作進度規劃明確且適宜</option>--}}
{{--                                                </optgroup>--}}
{{--                                                <optgroup label="美術">--}}
{{--                                                    <option value="遊戲角色很可愛">遊戲角色很可愛</option>--}}
{{--                                                    <option value="遊戲背景很漂亮">遊戲背景很漂亮</option>--}}
{{--                                                    <option value="遊戲UI很好看">遊戲UI很好看</option>--}}
{{--                                                </optgroup>--}}
{{--                                            </select>--}}
{{--                                            <textarea class="form-control autogrow" id="feedback_stu" name="feedback_stu" style="overflow: scroll; word-wrap: break-word; resize: horizontal; height: 150px;"></textarea>--}}
{{--                                            <input type="hidden" name="score_stu_id" id="score_stu_id">--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="modal-footer">--}}
{{--                                <button type="submit" class="btn btn-success waves-effect waves-light"  id="stu_send">送出</button>--}}
{{--                            </div>--}}
{{--                        </div><!-- /.modal-content -->--}}
{{--                    </div><!-- /.modal-dialog -->--}}
{{--                </div><!-- /.modal -->--}}

                <!-- 編輯同儕表現Modal -->
{{--                <div id="EditStuModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">--}}
{{--                    <div class="modal-dialog">--}}
{{--                        <div class="modal-content">--}}
{{--                            <div class="modal-header">--}}
{{--                                <h4 class="modal-title mt-0" id="myModalLabel">編輯同儕表現</h4>--}}
{{--                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
{{--                                    <span aria-hidden="true">&times;</span>--}}
{{--                                </button>--}}
{{--                            </div>--}}
{{--                            <div class="modal-body">--}}
{{--                                <div class="row">--}}
{{--                                    <div class="col-md-12">--}}
{{--                                        <div class="form-group">--}}
{{--                                            <label for="title" class="control-label">得分</label>--}}
{{--                                            <select name="edit_score_stu" id="edit_score_stu" class="form-control">--}}
{{--                                                <option value="100">100</option>--}}
{{--                                                <option value="90">90</option>--}}
{{--                                                <option value="80">80</option>--}}
{{--                                                <option value="70">70</option>--}}
{{--                                                <option value="60">60</option>--}}
{{--                                                <option value="50">50</option>--}}
{{--                                                <option value="40">40</option>--}}
{{--                                                <option value="30">30</option>--}}
{{--                                                <option value="20">20</option>--}}
{{--                                                <option value="10">10</option>--}}
{{--                                            </select>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="row">--}}
{{--                                    <div class="col-md-12">--}}
{{--                                        <div class="form-group no-margin">--}}
{{--                                            <label for="edit_feedback_stu" class="control-label">回饋</label>--}}
{{--                                            <select class="form-control select2" style="margin-bottom: 10px" onchange="edit_feedback_stu(this.value)">--}}
{{--                                                <option value="default">---請選擇回饋範例---</option>--}}
{{--                                                <optgroup label="企劃">--}}
{{--                                                    <option value="報告時臺風穩健">報告時臺風穩健</option>--}}
{{--                                                    <option value="報告內容有條理且清楚展示進度">報告內容有條理且清楚展示進度</option>--}}
{{--                                                    <option value="工作進度規劃明確且適宜">工作進度規劃明確且適宜</option>--}}
{{--                                                </optgroup>--}}
{{--                                                <optgroup label="美術">--}}
{{--                                                    <option value="遊戲角色很可愛">遊戲角色很可愛</option>--}}
{{--                                                    <option value="遊戲背景很漂亮">遊戲背景很漂亮</option>--}}
{{--                                                    <option value="遊戲UI很好看">遊戲UI很好看</option>--}}
{{--                                                </optgroup>--}}
{{--                                            </select>--}}
{{--                                            <textarea class="form-control autogrow" id="edit_feedback_stu" name="edit_feedback_stu" style="overflow: scroll; word-wrap: break-word; resize: horizontal; height: 150px;"></textarea>--}}
{{--                                            <input type="hidden" name="edit_stu_id" id="edit_stu_id">--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="modal-footer">--}}
{{--                                <button type="submit" class="btn btn-success waves-effect waves-light"  id="stu_edit">送出</button>--}}
{{--                            </div>--}}
{{--                        </div><!-- /.modal-content -->--}}
{{--                    </div><!-- /.modal-dialog -->--}}
{{--                </div><!-- /.modal -->--}}

                <!-- 評分組員表現Modal -->
{{--                <div id="ScoringMemberModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">--}}
{{--                    <div class="modal-dialog">--}}
{{--                        <div class="modal-content">--}}
{{--                            <div class="modal-header">--}}
{{--                                <h4 class="modal-title mt-0" id="myModalLabel">評分組員貢獻度</h4>--}}
{{--                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
{{--                                    <span aria-hidden="true">&times;</span>--}}
{{--                                </button>--}}
{{--                            </div>--}}
{{--                            <div class="modal-body">--}}
{{--                                <div class="row">--}}
{{--                                    <div class="col-md-12">--}}
{{--                                        <div class="form-group">--}}
{{--                                            <label for="title" class="control-label">組員表現</label>--}}
{{--                                            <select name="score_member" id="score_member" class="form-control">--}}
{{--                                                <option value="5">5</option>--}}
{{--                                                <option value="4">4</option>--}}
{{--                                                <option value="3">3</option>--}}
{{--                                                <option value="2">2</option>--}}
{{--                                                <option value="1">1</option>--}}
{{--                                            </select>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="row">--}}
{{--                                    <div class="col-md-12">--}}
{{--                                        <div class="form-group no-margin">--}}
{{--                                            <label for="feedback_stu" class="control-label">回饋</label>--}}
{{--                                            <select class="form-control select2" style="margin-bottom: 10px" onchange="feedback_member(this.value)">--}}
{{--                                                <option value="default">---請選擇回饋範例---</option>--}}
{{--                                                <optgroup label="企劃">--}}
{{--                                                    <option value="報告時臺風穩健">報告時臺風穩健</option>--}}
{{--                                                    <option value="報告內容有條理且清楚展示進度">報告內容有條理且清楚展示進度</option>--}}
{{--                                                    <option value="工作進度規劃明確且適宜">工作進度規劃明確且適宜</option>--}}
{{--                                                </optgroup>--}}
{{--                                                <optgroup label="美術">--}}
{{--                                                    <option value="遊戲角色很可愛">遊戲角色很可愛</option>--}}
{{--                                                    <option value="遊戲背景很漂亮">遊戲背景很漂亮</option>--}}
{{--                                                    <option value="遊戲UI很好看">遊戲UI很好看</option>--}}
{{--                                                </optgroup>--}}
{{--                                            </select>--}}
{{--                                            <textarea class="form-control autogrow" id="feedback_member" name="feedback_stu" style="overflow: scroll; word-wrap: break-word; resize: horizontal; height: 150px;"></textarea>--}}
{{--                                            <input type="hidden" name="score_member_id" id="score_member_id">--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="modal-footer">--}}
{{--                                <button type="submit" class="btn btn-success waves-effect waves-light"  id="member_send">送出</button>--}}
{{--                            </div>--}}
{{--                        </div><!-- /.modal-content -->--}}
{{--                    </div><!-- /.modal-dialog -->--}}
{{--                </div><!-- /.modal -->--}}

                <!-- 編輯組員表現Modal -->
{{--                <div id="EditMemberModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">--}}
{{--                    <div class="modal-dialog">--}}
{{--                        <div class="modal-content">--}}
{{--                            <div class="modal-header">--}}
{{--                                <h4 class="modal-title mt-0" id="myModalLabel">編輯組別貢獻度</h4>--}}
{{--                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
{{--                                    <span aria-hidden="true">&times;</span>--}}
{{--                                </button>--}}
{{--                            </div>--}}
{{--                            <div class="modal-body">--}}
{{--                                <div class="row">--}}
{{--                                    <div class="col-md-12">--}}
{{--                                        <div class="form-group">--}}
{{--                                            <label for="title" class="control-label">組員表現</label>--}}
{{--                                            <select name="edit_score_member" id="edit_score_member" class="form-control">--}}
{{--                                                <option value="5">5</option>--}}
{{--                                                <option value="4">4</option>--}}
{{--                                                <option value="3">3</option>--}}
{{--                                                <option value="2">2</option>--}}
{{--                                                <option value="1">1</option>--}}
{{--                                            </select>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="row">--}}
{{--                                    <div class="col-md-12">--}}
{{--                                        <div class="form-group no-margin">--}}
{{--                                            <label for="edit_feedback_stu" class="control-label">回饋</label>--}}
{{--                                            <select class="form-control select2" style="margin-bottom: 10px" onchange="edit_feedback_member(this.value)">--}}
{{--                                                <option value="default">---請選擇回饋範例---</option>--}}
{{--                                                <optgroup label="企劃">--}}
{{--                                                    <option value="報告時臺風穩健">報告時臺風穩健</option>--}}
{{--                                                    <option value="報告內容有條理且清楚展示進度">報告內容有條理且清楚展示進度</option>--}}
{{--                                                    <option value="工作進度規劃明確且適宜">工作進度規劃明確且適宜</option>--}}
{{--                                                </optgroup>--}}
{{--                                                <optgroup label="美術">--}}
{{--                                                    <option value="遊戲角色很可愛">遊戲角色很可愛</option>--}}
{{--                                                    <option value="遊戲背景很漂亮">遊戲背景很漂亮</option>--}}
{{--                                                    <option value="遊戲UI很好看">遊戲UI很好看</option>--}}
{{--                                                </optgroup>--}}
{{--                                            </select>--}}
{{--                                            <textarea class="form-control autogrow" id="edit_feedback_member" name="edit_feedback_member" style="overflow: scroll; word-wrap: break-word; resize: horizontal; height: 150px;"></textarea>--}}
{{--                                            <input type="hidden" name="edit_member_id" id="edit_member_id">--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="modal-footer">--}}
{{--                                <button type="submit" class="btn btn-success waves-effect waves-light"  id="member_edit">送出</button>--}}
{{--                            </div>--}}
{{--                        </div><!-- /.modal-content -->--}}
{{--                    </div><!-- /.modal-dialog -->--}}
{{--                </div><!-- /.modal -->--}}
            </div> <!-- container-fluid -->
        </div> <!-- content -->
    </div>

    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        //同儕回饋範本
        // function feedback_stu(value) {
        //     if(value != "default"){
        //         document.getElementById("feedback_stu").value += value + "\n" ;
        //     }
        // }
        //編輯同儕回饋範本
        // function edit_feedback_stu(value) {
        //     if(value != "default"){
        //         document.getElementById("edit_feedback_stu").value += "\n" + value ;
        //     }
        // }
        //組員回饋範本
        // function feedback_member(value) {
        //     if(value != "default"){
        //         document.getElementById("feedback_member").value += value + "\n" ;
        //     }
        // }
        //編輯組員回饋範本
        // function edit_feedback_member(value) {
        //     if(value != "default"){
        //         document.getElementById("edit_feedback_member").value += "\n" + value ;
        //     }
        // }

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

                                cv_id = []; //紀錄被評分組員的id

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

                                }else {
                                    // 有評分紀錄

                                }

                                // for (var i=3; i<data.length; i+=2){
                                //     if (data[i] == '0'){
                                //         html_stu += '<tr>';
                                //         html_stu += '<td>'+data[i-1]['name']+'</td>';
                                //         if (data[i-1]['position'] == 0){
                                //             html_stu += '<td>'+'企劃'+'</td>'
                                //         }else if(data[i-1]['position'] == 1){
                                //             html_stu += '<td>'+'程式'+'</td>'
                                //         }else{
                                //             html_stu += '<td>'+'美術'+'</td>'
                                //         }
                                //         html_stu += '<td>'+data[i]+'</td>';
                                //         html_stu += '<td>'+'<button class="score_member_modal btn btn-primary waves-effect waves-light m-l-10 button-font w-xs" data-toggle="modal" data-target="#ScoringMemberModal" data-mid="'+data[i-1]['student_id']+'">評分</button>'+'</td></tr>';
                                //         $('#stu').html(html_stu);
                                //     }else {
                                //         html_stu += '<tr>';
                                //         html_stu += '<td>'+data[i-1]['name']+'</td>';
                                //         if (data[i-1]['position'] == 0){
                                //             html_stu += '<td>'+'企劃'+'</td>'
                                //         }else if(data[i-1]['position'] == 1){
                                //             html_stu += '<td>'+'程式'+'</td>'
                                //         }else{
                                //             html_stu += '<td>'+'美術'+'</td>'
                                //         }
                                //         html_stu += '<td>'+data[i][0]['CV']+'</td>';
                                //         html_stu += '<td><button class="edit_member_modal btn btn-warning waves-effect waves-light m-l-10 button-font w-xs" data-toggle="modal" data-target="#EditMemberModal" data-mid="'+data[i-1]['student_id']+'" data-point="'+data[i][0]['CV']+'" data-feedback="'+data[i][0]['feedback']+'">編輯</button>'+'</td></tr>';
                                //         $('#stu').html(html_stu);
                                //     }
                                // }

                            }else {
                                // 使用者跟評分組別"不同組"

                                $('#member_part').hide();
                                $('#peer_part').show();

                                console.log(data)

                                // for (var i=3; i<data.length; i+=2){
                                //     if (data[i] == '0'){
                                //         html_stu += '<tr>';
                                //         html_stu += '<td>'+data[i-1]['name']+'</td>';
                                //         if (data[i-1]['position'] == 0){
                                //             html_stu += '<td>'+'企劃'+'</td>'
                                //         }else if(data[i-1]['position'] == 1){
                                //             html_stu += '<td>'+'程式'+'</td>'
                                //         }else{
                                //             html_stu += '<td>'+'美術'+'</td>'
                                //         }
                                //         html_stu += '<td>'+data[i]+'</td>';
                                //         html_stu += '<td>'+'<button class="score_stu_modal btn btn-primary waves-effect waves-light m-l-10 button-font w-xs" data-toggle="modal" data-target="#ScoringStudentModal" data-sid="'+data[i-1]['student_id']+'">評分</button>'+'</td></tr>';
                                //         $('#stu').html(html_stu);
                                //     }else {
                                //         html_stu += '<tr>';
                                //         html_stu += '<td>'+data[i-1]['name']+'</td>';
                                //         if (data[i-1]['position'] == 0){
                                //             html_stu += '<td>'+'企劃'+'</td>'
                                //         }else if(data[i-1]['position'] == 1){
                                //             html_stu += '<td>'+'程式'+'</td>'
                                //         }else{
                                //             html_stu += '<td>'+'美術'+'</td>'
                                //         }
                                //         html_stu += '<td>'+data[i][0]['EV']+'</td>';
                                //         html_stu += '<td><button class="edit_stu_modal btn btn-warning waves-effect waves-light m-l-10 button-font w-xs" data-toggle="modal" data-target="#EditStuModal" data-sid="'+data[i-1]['student_id']+'" data-point="'+data[i][0]['EV']+'" data-feedback="'+data[i][0]['feedback']+'">編輯</button>'+'</td></tr>';
                                //         $('#stu').html(html_stu);
                                //     }
                                // }
                            }
                        }
                    },
                    error: function (){
                        alert('加入失敗');
                    }
                })
            });
        }

        {{--$('#stu_send').click(function () {--}}
        {{--    //評分同儕--}}
        {{--    var score = $("#score_stu").val();--}}
        {{--    var feedback = $("#feedback_stu").val();--}}
        {{--    var id = $('#score_stu_id').val();--}}
        {{--    $(document).ready(function() {--}}
        {{--        $.ajax({--}}
        {{--            type:'POST',--}}
        {{--            url:'/APS_student/meeting/scoring_stu',--}}
        {{--            data:{id:id,--}}
        {{--                score:score,--}}
        {{--                feedback:feedback,--}}
        {{--                meeting_id: {{$meeting['id']}},--}}
        {{--                _token: '{{csrf_token()}}'},--}}
        {{--            dataType: 'json',--}}
        {{--            success: function(data) {--}}
        {{--                alert(data)--}}
        {{--                $('#ScoringStudentModal').modal('hide')--}}
        {{--                document.getElementById("feedback_stu").value="";--}}
        {{--                check()--}}
        {{--            },--}}
        {{--            error: function (){--}}
        {{--                alert('評分失敗')--}}
        {{--            }--}}
        {{--        });--}}
        {{--    });--}}
        {{--});--}}

        // $(document).on('click', '.edit_stu_modal', function() {
        //     //開啟編輯同儕modal, 輸入編輯前的值
        //     $('#edit_score_stu').val($(this).data('point'));
        //     $('#edit_feedback_stu').val($(this).data('feedback'));
        //     $('#edit_stu_id').val($(this).data('sid'));
        // });

        {{--$('#stu_edit').click(function () {--}}
        {{--    //編輯同儕--}}
        {{--    var score = $("#edit_score_stu").val();--}}
        {{--    var feedback = $("#edit_feedback_stu").val();--}}
        {{--    var id = $('#edit_stu_id').val();--}}
        {{--    $(document).ready(function() {--}}
        {{--        $.ajax({--}}
        {{--            type:'POST',--}}
        {{--            url:'/APS_student/meeting/edit_stu',--}}
        {{--            data:{id:id,--}}
        {{--                score:score,--}}
        {{--                feedback:feedback,--}}
        {{--                meeting_id: {{$meeting['id']}},--}}
        {{--                _token: '{{csrf_token()}}'},--}}
        {{--            dataType: 'json',--}}
        {{--            success: function(data) {--}}
        {{--                alert(data)--}}
        {{--                $('#EditStuModal').modal('hide')--}}
        {{--                check()--}}
        {{--            },--}}
        {{--            error: function (){--}}
        {{--                alert('編輯失敗')--}}
        {{--            }--}}
        {{--        });--}}
        {{--    });--}}
        {{--});--}}


        // $(document).on('click', '.score_member_modal', function() {
        //     //開啟評分組員modal
        //     $('#score_member_id').val($(this).data('mid'));
        // });

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

        // $(document).on('click', '.edit_member_modal', function() {
        //     //開啟編輯組員modal, 輸入編輯前的值
        //     $('#edit_score_member').val($(this).data('point'));
        //     $('#edit_feedback_member').val($(this).data('feedback'));
        //     $('#edit_member_id').val($(this).data('mid'));
        // });

        {{--$('#member_edit').click(function () {--}}
        {{--    //編輯組員--}}
        {{--    var score = $("#edit_score_member").val();--}}
        {{--    var feedback = $("#edit_feedback_member").val();--}}
        {{--    var id = $('#edit_member_id').val();--}}
        {{--    $(document).ready(function() {--}}
        {{--        $.ajax({--}}
        {{--            type:'POST',--}}
        {{--            url:'/APS_student/meeting/edit_member',--}}
        {{--            data:{id:id,--}}
        {{--                score:score,--}}
        {{--                feedback:feedback,--}}
        {{--                meeting_id: {{$meeting['id']}},--}}
        {{--                _token: '{{csrf_token()}}'},--}}
        {{--            dataType: 'json',--}}
        {{--            success: function(data) {--}}
        {{--                alert(data)--}}
        {{--                $('#EditMemberModal').modal('hide')--}}
        {{--                check()--}}
        {{--            },--}}
        {{--            error: function (){--}}
        {{--                alert('編輯失敗')--}}
        {{--            }--}}
        {{--        });--}}
        {{--    });--}}
        {{--});--}}

    </script>
@endsection
@section('title','互評')

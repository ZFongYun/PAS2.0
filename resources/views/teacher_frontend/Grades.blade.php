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
                                    @for($i=1;$i<count($report_team_arr);$i++)
                                        <option value="{{$report_team_arr[$i]}}">{{$report_team_arr[$i]}}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>

                    </div>

                    <div class="alert alert-success" role="alert" id="success" style="display: none; width: 60%">
                        已完成結算。
                    </div>

                    <div class="alert alert-danger" role="alert" id="danger" style="display: none; width: 60%">
                        未完成結算，請點選右邊按鈕進行結算。
                        <button type="submit" class="send btn btn-icon waves-effect waves-light btn-success" data-mid="{{$meeting['id']}}">結算</button>
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
            var html = '';
            var html_stu = '';
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
                        console.log(data)
                        if (data == 'null'){
                            $('#team_table').hide();
                            $('#team_title').hide();
                            $('#member_table').hide();
                            $('#member_title').hide();
                            html = '';
                            html_stu = '';
                        }else {
                            if (data[0] == ''){
                                console.log('空')
                                $('#danger').show();
                                $('#success').hide();
                            }else {
                                console.log('否')
                                $('#danger').hide();
                                $('#success').show();
                            }
                        }
                    },
                    error: function (){
                        alert('加入失敗');
                    }
                })
            });
        }
    </script>
@endsection
@section('title','結算成績')

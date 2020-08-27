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
                            <h4 class="page-title">[ 評分 ] {{$meeting['name']}}</h4>
                        </div>
                        <div class="form-group row">
                            <label for="public" class="col-sm-1 control-label form-title">選擇評分組別</label>
                            <div class="col-md-5">
                                <select name="team" id="team" class="form-control" onchange="check()">
                                    <option default>請選擇</option>
                                    @for($i=1;$i<count($report_team_arr);$i++)
                                    <option value="{{$report_team_arr[$i]}}">{{$report_team_arr[$i]}}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <p class="form-title">◎ 評分組別</p>
                        <div class="table-responsive">
                            <table class="table table-hover m-0" id="team_table" style="display: none">
                                <thead>
                                <tr>
                                    <th>組別名稱</th>
                                    <th>分數</th>
                                    <th width="10%"></th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>

{{--                        <p class="form-title p-t-10">◎ 評分組員</p>--}}
{{--                        <div class="table-responsive">--}}
{{--                            <table class="table table-hover m-0" id="member_table" style="display: none">--}}
{{--                                <thead>--}}
{{--                                <tr>--}}
{{--                                    <th>學號</th>--}}
{{--                                    <th>姓名</th>--}}
{{--                                    <th>職務</th>--}}
{{--                                    <th>分數</th>--}}
{{--                                    <th width="10%"></th>--}}
{{--                                </tr>--}}
{{--                                </thead>--}}
{{--                                <tbody>--}}

{{--                                </tbody>--}}
{{--                            </table>--}}
{{--                        </div>--}}


                    </div>
                </div>



            </div> <!-- container-fluid -->

    </div>
        <script type="text/javascript">
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var check=function(){
                var html = '';
                var team = $("#team").val();
                $(document).ready(function() {
                    $.ajax({
                        type:'POST',
                        url:'/meeting/score',
                        data:{team:team,
                            meeting_id: {{$meeting['id']}},
                            _token: '{{csrf_token()}}'},
                        dataType: 'json',
                        success: function(data) {
                            if (data[1][0] == '0'){
                                alert('no scoring')
                                $('#team_table').show();
                                html += '<tr>';
                                html += '<td>'+data[0]+'</td>';
                                html += '<td>'+data[1][0]+'</td>';
                                html += '<td>'+'</td></tr>';
                                $('tbody').html(html);
                            }else {
                                alert('has scoring')
                                $('#team_table').show();
                                html += '<tr>';
                                html += '<td>'+data[0]+'</td>';
                                html += '<td>'+data[1][0]['point']+'</td>';
                                html += '<td>'+'</td></tr>';
                                $('tbody').html(html);
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
@section('title','會議評分')

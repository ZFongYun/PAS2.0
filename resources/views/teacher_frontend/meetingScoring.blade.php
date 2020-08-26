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
                var team = $("#team").val();
                $(document).ready(function() {
                    $.ajax({
                        type:'POST',
                        url:'/meeting/score',
                        data:{team:team, _token: '{{csrf_token()}}'},
                        success: function(data) {
                            alert(data);
                            console.log(data);
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

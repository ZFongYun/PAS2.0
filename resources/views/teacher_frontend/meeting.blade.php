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
                            <h4 class="page-title">會議管理</h4>
                            <a href="{{route('meeting.create')}}" class="btn btn-primary waves-effect m-l-15 waves-light m-b-5">新增會議</a>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover m-0">
                                <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="10%">學年期</th>
                                    <th width="20%">會議名稱</th>
                                    <th width="20%">會議日期與起止時間</th>
                                    <th width="5%">編輯</th>
                                    <th width="5%">詳情</th>
                                    <th width="5%">刪除</th>
{{--                                    <th width="10%">進入評分</th>--}}
                                    <th width="5%">結算成績</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($meeting as $row)
                                    <tr>
                                        <td>{{$row['id']}}</td>
                                        <td>{{$row['year']}} - {{$row['semester']== 0 ? '1' : '2'}}</td>
                                        <td>{{$row['name']}}</td>
                                        <td>{{$row['meeting_date']."　".date("H : i",strtotime($row['meeting_start'])). " ~ " .date("H : i",strtotime($row['meeting_end']))}}</td>
                                        <td><a href="{{route('meeting.edit',$row['id'])}}" class="btn btn-icon waves-effect waves-light btn-warning"><i class="zmdi zmdi-edit"></i></a></td>
                                        <td><a href="{{route('meeting.show',$row['id'])}}" class="btn btn-icon waves-effect waves-light btn-info"><i class="zmdi zmdi-info-outline"></i></a></td>
                                        <form action="{{route('meeting.destroy',$row['id'])}}" method="post">
                                            <td><button type="submit" class="btn btn-icon waves-effect waves-light btn-danger m-b-5" onclick="return(confirm('是否刪除此筆資料？'))"> <i class="fa fa-remove"></i> </button></td>
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        </form>
{{--                                        <td><a href="{{action('MeetingController@scoring_page',$row['id'])}}" class="btn btn-icon waves-effect waves-light btn-primary"><i class="fa fa-sign-in"></i></a></td>--}}
                                        <td><a href="{{action('ScoreController@grades_page',$row['id'])}}" class="btn btn-icon waves-effect waves-light btn-success"><i class="fa fa-file-o"></i></a></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
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

        $(document).on('click', '.send', function() {
            $('#score_send').val($(this).data('mid'));
            var id = $("#score_send").val();
            $(document).ready(function() {
                $.ajax({
                    type:'POST',
                    url:'/score',
                    data:{id:id,
                        _token: '{{csrf_token()}}'},
                    success: function(data) {
                        alert(data)
                    },
                    error: function (){
                        alert('結算失敗')
                    }

                });
            });
        });

    </script>
@endsection
@section('title','會議管理')

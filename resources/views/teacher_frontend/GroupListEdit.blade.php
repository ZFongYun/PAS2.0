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
                            <h4 class="page-title">編輯組別</h4>
                        </div>

{{--                        <form method="post" action="{{route('GroupList.update')}}">--}}
                            {{ csrf_field() }}
                            <div class="col-lg-10">
                                <div class="form-group row">
                                    <label for="name" class="col-sm-2 control-label form-title" >組別名稱</label>
                                    <div class="col-md-5" >
                                        <input type="text" class="form-control" id="name" name="name" value="{{$team_name}}" required="">
                                    </div>
                                </div>

                                <p class="form-title">編輯組員</p>

                                @if($messageWarning = Session::get('warning'))
                                    <div class="alert alert-warning alert-block" style="color: #f0b360">
                                        <button type="button" class="close" data-dismiss="alert">×</button>
                                        {{ $messageWarning }}
                                    </div>
                                @endif

                                @if($messageRepeat = Session::get('repeat'))
                                    <div class="alert alert-danger alert-block" style="color: #EE5959">
                                        <button type="button" class="close" data-dismiss="alert">×</button>
                                        {{ $messageRepeat }}
                                    </div>
                                @endif

                                @if($messageError = Session::get('error'))
                                    <div class="alert alert-danger alert-block" style="color: #EE5959">
                                        <button type="button" class="close" data-dismiss="alert">×</button>
                                        {{ $messageError }}
                                    </div>
                                @endif

                                <div class="table-responsive">
                                    <table class="table table-hover m-0">
                                        <thead>
                                        <tr>
                                            <th></th>
                                            <th>學號</th>
                                            <th>姓名</th>
                                            <th>角色</th>
                                            <th>職位</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @for($i=0; $i<$student_length; $i++)
                                            <tr>
                                                <td><input type='checkbox' name='student[]' value="{{$student[$i]['id']}}" id="{{$student[$i]['id']}}" data-id="{{$student[$i]['student_id']}}" data-name="{{$student[$i]['name']}}" data-role="{{$student[$i]['role']}}" data-position="{{$student[$i]['position']}}" class="check_box"></td>
                                                <td>{{$student[$i]['student_id']}}</td>
                                                <td>{{$student[$i]['name']}}</td>
                                                @if($student[$i]['role']==0)
                                                    <td>組長</td>
                                                @elseif($student[$i]['role']==1)
                                                    <td>組員</td>
                                                @endif
                                                @if($student[$i]['position']==0)
                                                    <td>企劃</td>
                                                @elseif($student[$i]['position']==1)
                                                    <td>程式</td>
                                                @elseif($student[$i]['position']==2)
                                                    <td>美術</td>
                                                @endif
                                            </tr>

                                        @endfor
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="col-lg-10 m-t-30" align="right">
                                <button type="submit" class="btn btn-success waves-effect waves-light button-font">確認</button>
                            </div><!-- end col -->
{{--                        </form>--}}
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

        $(document).ready(function() {
            $(document).on('click', '.check_box', function(){
                var html = '';
                if(this.checked)
                {
                    html = '<td><input type="checkbox" name="student[]" value="'+$(this).attr('id')+'" id="'+$(this).attr('id')+'" data-id="'+$(this).data('id')+'" data-name="'+$(this).data('name')+'" data-class="'+$(this).data('class')+'" data-role="'+$(this).data('role')+'" data-position="'+$(this).data('position')+'" class="check_box" checked /></td>';
                    html += '<td>'+$(this).data('id')+'</td>';
                    html += '<td>'+$(this).data('name')+'</td>';
                    html += '<td><select id="role" name="role'+$(this).attr('id')+'"><option value="0">組長</option> <option value="1" selected>組員</option> </select></td>';
                    html += '<td><select id="position" name="position'+$(this).attr('id')+'"><option value="0">企劃</option><option value="1">程式</option><option value="2">美術</option> </select></td>';
                }
                else
                {
                    html = '<td><input type="checkbox" name="student[]" value="'+$(this).attr('id')+'" id="'+$(this).attr('id')+'" data-id="'+$(this).data('id')+'" data-name="'+$(this).data('name')+'" data-class="'+$(this).data('class')+'" data-role="'+$(this).data('role')+'" data-position="'+$(this).data('position')+'" class="check_box" /></td>';
                    html += '<td>'+$(this).data('id')+'</td>';
                    html += '<td>'+$(this).data('name')+'</td>';
                    if($(this).data('role')==0){
                        html += '<td>'+'組長'+'</td>';
                    }
                    else if($(this).data('role')==1){
                        html += '<td>'+'組員'+'</td>';
                    }
                    if($(this).data('position')==0){
                        html += '<td>'+'企劃'+'</td>';
                    }
                    else if($(this).data('position')==1){
                        html += '<td>'+'程式'+'</td>';
                    }else if($(this).data('position')==2){
                        html += '<td>'+'美術'+'</td>';
                    }
                }
                $(this).closest('tr').html(html);
                // $('#gender_'+$(this).attr('id')+'').val($(this).data('gender'));
            });

        });


    </script>

@endsection
@section('title','編輯組別')

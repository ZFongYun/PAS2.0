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
                            <h4 class="page-title">新增組別</h4>
                        </div>

                        <form method="post" action="{{route('GroupList.store')}}">
                            {{ csrf_field() }}
                            <div class="col-lg-10">
                                <div class="form-group row">
                                    <label for="name" class="col-sm-2 control-label form-title" ><span class="text-danger">*</span>組別名稱</label>
                                    <div class="col-md-5" >
                                        <input type="text" class="form-control" id="name" name="name" required="">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="year" class="col-sm-2 control-label form-title" ><span class="text-danger">*</span>新增學年度</label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                            <input type="text" class="form-control m-r-10" id="year" name="year" required="">
                                            <select class="form-control" id="semester" name="semester">
                                                <option value="0">上學期</option>
                                                <option value="1">下學期</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="content" class="col-md-2 control-label form-title">組別簡介</label>
                                    <div class="col-md-5">
                                        <textarea id="content" name="content" class="form-control" maxlength="225" rows="2"></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="status" class="col-md-2 control-label form-title"><span class="text-danger">*</span>組別狀態</label>
                                    <div class="col-md-5">
                                        <select class="form-control" id="status" name="status">
                                            <option value="0">未結束</option>
                                            <option value="1">已結束</option>
                                        </select>
                                    </div>
                                </div>
                                <p class="form-title"><span class="text-danger">*</span>選擇組員</p>

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
                                    <table class="table table-hover m-0" style="text-align: center">
                                        <thead>
                                        <tr>
                                            <th></th>
                                            <th>學號</th>
                                            <th>姓名</th>
                                            <th>班級</th>
                                            <th>角色</th>
                                            <th>職位</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($student as $row)
                                            <tr>
                                                <td><input type='checkbox' name='student[]' value="{{$row['id']}}" id="{{$row['id']}}" data-id="{{$row['student_ID']}}" data-name="{{$row['name']}}" data-class="{{$row['class']}}" class="check_box"></td>
                                                <td>{{$row['student_ID']}}</td>
                                                <td>{{$row['name']}}</td>
                                                <td>{{$row['class']}}</td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="col-lg-10 m-t-30" align="right">
                                <button type="submit" class="btn btn-success waves-effect waves-light button-font">確認</button>
                            </div><!-- end col -->
                        </form>

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
                    html += '<td>'+$(this).data('class')+'</td>';
                    html += '<td><select id="role" name="role'+$(this).attr('id')+'"><option value="0">組長</option> <option value="1" selected>組員</option> </select></td>';
                    html += '<td><select id="position" name="position'+$(this).attr('id')+'"><option value="0">企劃</option><option value="1">程式</option><option value="2">美術</option> </select></td>';
                }
                else
                {
                    html = '<td><input type="checkbox" name="student[]" value="'+$(this).attr('id')+'" id="'+$(this).attr('id')+'" data-id="'+$(this).data('id')+'" data-name="'+$(this).data('name')+'" data-class="'+$(this).data('class')+'" data-role="'+$(this).data('role')+'" data-position="'+$(this).data('position')+'" class="check_box" /></td>';
                    html += '<td>'+$(this).data('id')+'</td>';
                    html += '<td>'+$(this).data('name')+'</td>';
                    html += '<td>'+$(this).data('class')+'</td>';
                    html += '<td>'+'</td>';
                    html += '<td>'+'</td>';
                }
                $(this).closest('tr').html(html);
            });
        });
    </script>

@endsection
@section('title','新增組別')

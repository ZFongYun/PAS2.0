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

                        <form method="post" id="update_form">
                            {{ csrf_field() }}
                            <div class="col-lg-10">
                                    <div class="form-group row">
                                        <label for="name" class="col-sm-2 control-label form-title" >組別名稱</label>
                                        <div class="col-md-5" >
                                            <input type="text" class="form-control" id="name" name="name" required="">
                                        </div>
                                    </div>

                                <p class="form-title">選擇組員</p>
                                <div class="table-responsive">
                                    <table class="table table-hover m-0">
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
                                                <td><input type='checkbox' name='student[]' id="{{$row['id']}}" data-id="{{$row['student_ID']}}" data-name="{{$row['name']}}" data-class="{{$row['class']}}" data-role="{{$row['role']}}" data-position="{{$row['position']}}" class="check_box"></td>
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

                            <div class="col-lg-10 m-t-30" align="center">
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
                    html = '<td><input type="checkbox" id="'+$(this).attr('id')+'" data-id="'+$(this).data('id')+'" data-name="'+$(this).data('name')+'" data-class="'+$(this).data('class')+'" data-role="'+$(this).data('role')+'" data-position="'+$(this).data('position')+'" class="check_box" checked /></td>';
                    html += '<td>'+$(this).data('id')+'</td>';
                    html += '<td>'+$(this).data('name')+'</td>';
                    html += '<td>'+$(this).data('class')+'</td>';
                    html += '<td><select id="role" name="role"><option value="0">組長</option> <option value="1" selected>組員</option> </select></td>';
                    html += '<td><select id="position" name="position"><option value="0">企劃</option><option value="1">程式</option><option value="1">美術</option> </select></td>';
                }
                else
                {
                    html = '<td><input type="checkbox" id="'+$(this).attr('id')+'" data-id="'+$(this).data('id')+'" data-name="'+$(this).data('name')+'" data-class="'+$(this).data('class')+'" data-role="'+$(this).data('role')+'" data-position="'+$(this).data('position')+'" class="check_box" /></td>';
                    html += '<td>'+$(this).data('id')+'</td>';
                    html += '<td>'+$(this).data('name')+'</td>';
                    html += '<td>'+$(this).data('class')+'</td>';
                    html += '<td>'+'</td>';
                    html += '<td>'+'</td>';
                }
                $(this).closest('tr').html(html);
                // $('#gender_'+$(this).attr('id')+'').val($(this).data('gender'));
            });

            $('#update_form').on('submit', function(event){
                event.preventDefault();
                if($('.check_box:checked').length > 0)
                {
                    $.ajax({
                        url:'{{route('GroupList.store')}}',
                        method:"POST",
                        data:$(this).serialize(),
                        success:function()
                        {
                            alert('Data Updated');
                            // fetch_data();

                        }
                    })
                }
                console.log($(this).serialize())
            });
        });


    </script>

@endsection
@section('title','新增組別')

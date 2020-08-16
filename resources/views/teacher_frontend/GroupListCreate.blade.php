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

                        <form action="#" method="post">
                            <div class="col-lg-10">
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="name" class="col-sm-4 control-label form-title">組別名稱</label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" id="name" name="name" required="">
                                        </div>
                                    </div>
                                </div>
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
                                                <td><input type='checkbox' name='student[]' value='{{$row['id']}}' onclick="showSelect(this);"></td>
                                                <td>{{$row['student_ID']}}</td>
                                                <td>{{$row['name']}}</td>
                                                <td>{{$row['class']}}</td>
                                                <td><select id="role{{$row['id']}}" name="role" style="display:none;">
                                                        <option value="0">組長</option>
                                                        <option value="1" selected>組員</option>
                                                    </select></td>
                                                <td><select id="position{{$row['id']}}" name="position" style="display:none;">
                                                        <option value="0">企劃</option>
                                                        <option value="1">程式</option>
                                                        <option value="1">美術</option>
                                                    </select></td>

                                            </tr>
                                            <script type="text/javascript">
                                                function showSelect(obj){
                                                    if(obj.checked){
                                                        document.getElementById("role{{$row['id']}}").style.display="";
                                                        document.getElementById("position{{$row['id']}}").style.display="";
                                                    }else{
                                                        document.getElementById("role{{$row['id']}}").style.display="none";
                                                        document.getElementById("position{{$row['id']}}").style.display="none";
                                                    }
                                                }
                                            </script>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="col-sm-6 m-t-30" align="center">
                                <button type="submit" class="btn btn-success waves-effect waves-light button-font">確認</button>
                            </div><!-- end col -->
                        </form>

                    </div>
                </div>



            </div> <!-- container-fluid -->

        </div> <!-- content -->

    </div>

@endsection
@section('title','新增組別')

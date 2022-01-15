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
                            <h4 class="page-title">成員名單</h4>
                            <button class="btn btn-primary waves-effect waves-light m-l-10 button-font" data-toggle="modal" data-target="#myModal">加入成員</button>
                        </div>
                        <p>總人數：{{$total}}</p>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                                <ul>
                                    <strong>加入失敗</strong>
                                </ul>
                            </div>
                        @endif
                        @if($message = Session::get('success'))
                            <div class="alert alert-success alert-block">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <strong>{{ $message }}</strong>
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-hover m-0" style="text-align: center">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>學號</th>
                                    <th>姓名</th>
                                    <th>班級</th>
                                    <th>刪除</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($student as $row)
                                <tr>
                                    <td>{{$row['id']}}</td>
                                    <td>{{$row['student_ID']}}</td>
                                    <td>{{$row['name']}}</td>
                                    <td>{{$row['class']}}</td>
                                    <form action="{{route('ImportStudent.destroy',$row['id'])}}" method="post">
                                        <td><button type="submit" class="btn btn-icon waves-effect waves-light btn-danger m-b-5" onclick="return(confirm('是否刪除此筆資料？'))"> <i class="fa fa-remove"></i> </button></td>
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    </form>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                    <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title mt-0" id="myModalLabel">加入成員</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="{{ route('ImportStudent.store') }}" method="POST" name="importform" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="title" class="form-title">匯入檔案</label>
                                                    <input type="file" name="import_file" class="form-control">
                                                    <h4>匯入成員說明</h4>
                                                    <ol>
                                                        <li>請先<a href="{{route('Overall.download')}}">點選我</a>下載檔案規格，編輯時請依照欄位標題輸入學生資料，完成後請將<mark>第一列移除</mark>，並儲存成 .xlcx 或 .csv。</li>
                                                        <li>上傳該份文件後，點擊右下方「送出」按鈕。</li>
                                                        <li>若匯入學號已為此課程中的成員，則不做處理；反之則加入為成員。</li>
                                                    </ol>
                                                    <p>預設密碼說明：在加入名單的同時，將會幫學生建立好帳號與密碼</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-custom waves-effect waves-light">送出</button>
                                    </div>
                                </form>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->
                </div>
            </div> <!-- container-fluid -->
        </div> <!-- content -->
    </div>
@endsection
@section('title','成員名單')

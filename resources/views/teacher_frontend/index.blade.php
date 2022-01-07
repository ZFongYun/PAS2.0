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
                            <h4 class="page-title">會議公告</h4>
                            <button class="btn btn-primary waves-effect waves-light m-l-10 button-font" data-toggle="modal" data-target="#myModal">新增</button>
                        </div>

                        <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title mt-0" id="myModalLabel">新增公告</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="{{action('ProfIndexController@store')}}" method="post">
                                        {{ csrf_field() }}
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="title" class="control-label">標題</label>
                                                    <input type="text" class="form-control" id="title" name="title">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group no-margin">
                                                    <label for="content" class="control-label">內容</label>
                                                    <textarea class="form-control autogrow" id="content" name="content" style="overflow: hidden; word-wrap: break-word; resize: horizontal; height: 104px;"></textarea>
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

                        <div class="row">
                            @foreach($bulletin as $row)
                            <div class="col-lg-8">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="dropdown float-right">
                                            <a href="#" class="dropdown-toggle card-drop" data-toggle="dropdown"
                                               aria-expanded="false">
                                                <i class="zmdi zmdi-more-vert"></i>
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-right">
                                                <li><a href="#myModal{{$row['id']}}" data-toggle="modal" class="dropdown-item">編輯</a></li>
                                                <form action="{{route('Overall.destroy',$row['id'])}}" method="post">
                                                    <li><button type="submit" class="dropdown-item button-dropdown" style="padding-left: 20px;" onclick="return(confirm('是否刪除此筆資料？'))">刪除</button></li>
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                </form>
                                            </ul>
                                        </div>

                                        <h4 class="header-title m-t-0 m-b-30">{{$row['title']}}</h4>

                                        <p class="mb-0">
                                            {{$row['content']}}
                                        </p>
                                    </div>
                                </div>
                            </div><!-- end col -->

                                <!-- 編輯Modal -->
                                <div id="myModal{{$row['id']}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title mt-0" id="myModalLabel">編輯公告</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="{{route('Overall.update',$row['id'])}}" method="post">
                                                {{ csrf_field() }}
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="title" class="control-label">標題</label>
                                                                <input type="text" class="form-control" id="title" name="title" value="{{$row['title']}}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group no-margin">
                                                                <label for="content" class="control-label">內容</label>
                                                                <textarea class="form-control autogrow" id="content" name="content" style="overflow: hidden; word-wrap: break-word; resize: horizontal; height: 104px;">{{$row['content']}}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <input type="hidden" name="_method" value="PUT">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-custom waves-effect waves-light">送出</button>
                                                </div>

                                            </form>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div><!-- /.modal -->

                            @endforeach
                        </div>





                    </div>
                </div>



            </div> <!-- container-fluid -->

        </div> <!-- content -->

    </div>
@endsection
@section('title','首頁')

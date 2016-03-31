@extends('layouts.layout')

@section('js_css')
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h2 class="page-header">課程內容</h2>
            <div class="table-responsive img-rounded" style="padding-bottom:40px">

                {{ Form::open(['route' => ['file.upload', $course->id], 'enctype' => 'multipart/form-data', 'style'=>'margin-bottom:0px']) }}
                <table class="table" style="table-layout:fixed; margin-bottom:0px" align="center" valign="middle">
                    <thead>
                        <tr style="background-color:DEEEFF; height:50px">
                            <td align='center' colspan="1" style="font-weight:bolder">課程分類</td>
                            <td align='center' colspan="2">
                                <p>
                                    @if($course->is_for_student)
                                        學生自主服務
                                    @else
                                        服務學習課程
                                    @endif
                                </p>
                            </td>
                            <td align='center' colspan="1" style="font-weight:bolder">資料公告日期</td>
                            <td align='center' colspan="1">{{ $course->created_at->toDateString() }}</td>

                            <td align='center' colspan="2">
                                @if(auth()->check() && auth()->user()->isAdmin() ) 
                                    <div class="dropdown">
                                      <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" style="width:80%">後臺操作<span class="caret"></span>
                                      </button>
                                      <ul class="dropdown-menu" >
                                        <li><a href="{{URL::route('course.edit', $course->id)}}">內容修改</a></li>
                                        <li><a data-toggle="modal" data-target="#modal{{$course->id}}">新增教學檔案</a></li>
                                        <li><a href="{{URL::route('log.show', $course->id)}}">修改紀錄</a></li>
                                        <li><a data-method="delete" href="{{URL::route('course.destroy', $course->id)}}">整筆刪除</a></li>
                                      </ul>
                                    </div>
                                @endif
                            </td>
                        </tr>

                        <div id="modal{{$course->id}}" class="modal fade" tabindex="-1" role="dialog">
                          <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" style="font-weight:bolder">新增教學檔案</h4>
                                </div>
                                <div class="modal-footer">
                                    <div class="checkbox">
                                        <input name="is_login_need" type="hidden" value="0">
                                        <input name="is_login_need" type="checkbox" value="1">是否需登入中大portal帳號
                                    </div>
                                    <input id="{{$course->id}}" name="upload_file[]" type="file" class="file-loading" >
                                </div>
                            </div>
                          </div>
                        </div>
                    </thead>
                    <tbody>    
                        <tr>
                            <td align='center' colspan="1" style="font-weight:bolder">教學內容</td>
                            <td colspan="6">
                                <p style="font-weight:bolder">【&nbsp;課程標題&nbsp;】</p>
                                <p style="word-break:break-word;">{{ $course->title }}</p>
                                <p style="font-weight:bolder">【&nbsp;課程說明&nbsp;】</p>
                                <p style="word-break:break-word; white-space:pre-line;">{{ $course->message }}</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
                {{ Form::close() }}
            </div>

            <h2 class="page-header">教學檔案</h2>
            <div class="table-responsive img-rounded" style="padding-bottom:20px">
                @if( count($course->files) == 0 )
                    <table class="table" style="table-layout:fixed; margin-bottom:0px; background-color:#f9f9f9" align="center" valign="middle">
                        <tr style="background-color:DEEEFF;">
                            <td align='center' style="font-weight:bolder"><p>無教學檔案</p></td>
                        </tr>
                    </table>
                @else
                    {{ Form::open(['route' => ['questionnaire.store', $course->id]]) }}
                    <table style="table-layout:fixed" class="table table-striped" align="center" valign="middle">
                        @foreach($course->files as $file)

                            <tr>
                                <td align='center' style="font-weight:bolder"><p>教學檔案</p></td>
                                <td align='center' colspan="2" style= "word-break:break-all; "> 
                                    @if($file->is_login_need && !auth()->check())
                                        <p>{{ $file->title }}</p>
                                    @else
                                        <a  href="{{ URL::route('file.download', $file->id) }}"><p data-toggle="modal" data-target="#modal_questionnaire{{$course->id}}" >{{ $file->title }}</p></a>
                                    @endif
                                </td>
                                <td align='center' style="font-weight:bolder">
                                    <p>下載次數</p>
                                </td>
                                <td align='center'>
                                    <p>{{ $file->download_times }}</p>
                                </td>
                                <td align='center' style="font-weight:bolder">
                                    <p>
                                    @if($file->is_login_need)
                                        限中大portal帳號
                                    @else
                                        不限下載權限
                                    @endif
                                    </p>
                                </td>
                                <td align='center'>
                                    @if( auth()->check() && auth()->user()->isAdmin() )
                                        <button class="btn btn-default" type="button" style="width:80%">
                                            <a data-method="delete"  href="{{ URL::route('file.destroy', $file->id)}}" style="color:#000000">刪除檔案</a>
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        <div id="modal_questionnaire{{$course->id}}" class="modal fade" tabindex="-1" role="dialog">
                          <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" style="font-weight:bolder">你喜歡這門課嗎?</h4>
                                </div>
                                <div class="modal-body">
                                    <input name="satisfaction" type="hidden" value="0">
                                    <label class="radio-inline"><input type="radio" name="satisfaction" value="1">喜歡</label>
                                    <label class="radio-inline"><input type="radio" name="satisfaction" value="2">普通</label>
                                    <label class="radio-inline"><input type="radio" name="satisfaction" value="3">內容需要修改</label>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary btn-lg">送出</button>
                                </div>

                            </div>
                          </div>
                        </div>
                    </table>
                    {{ Form::close() }}
                @endif
            </div>
        </div>
    </div>
@stop

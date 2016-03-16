@extends('layouts.layout')

@section('js_css')
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div align='center'>
                {{ $courses->links() }}
            </div>
            
            <div class="table-responsive" style="padding-bottom:20px">
                @foreach($courses as $course)
                    {{ Form::open(['route' => ['file.upload', $course->id], 'enctype' => 'multipart/form-data', 'style'=>'margin-bottom:0px']) }}
                    <table class="table table-striped table-bordered" style="table-layout:fixed; margin-bottom:0px" align="center" valign="middle">
                        <div>
                            <tr height="50px" style="border-style:double">
                                <td align='center' colspan="1" style="font-weight:bolder">使用對象</td>
                                <td align='center' colspan="2">
                                    <p>
                                        @if($course->is_for_student)
                                            學生&nbsp;
                                        @endif
                                        @if($course->is_for_teacher)
                                            教師&nbsp;
                                        @endif
                                        @if($course->is_for_staff)
                                            職員&nbsp;
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
                                            <input name="is_login_need" type="checkbox" value="1">需登入中大portal帳號
                                        </div>
                                        <input id="{{$course->id}}" name="upload_file[]" type="file" class="file-loading" >
                                    </div>
                                </div>
                              </div>
                            </div>
                            <tr style="border-style:double">
                                <td align='center' colspan="1" style="font-weight:bolder">教學內容</td>
                                <td colspan="6">
                                    <p>標題：{{ $course->title }}</p>
                                    <p>內文：{{ $course->message }}</p>
                                </td>
                            </tr>
                        </div>
                    </table>
                    {{ Form::close() }}

                    {{ Form::open(['route' => ['questionnaire.store', $course->id]]) }}
                    <table style="table-layout:fixed" class="table table-striped table-bordered" align="center" valign="middle">

                        @foreach($course->files as $file)

                            <tr style="border-style:double">
                                <td align='center' style="font-weight:bolder">教學檔案</td>
                                <td align='center' colspan="2"> 
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
                                        不限
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
                                    <h4 class="modal-title" style="font-weight:bolder">滿意度調查</h4>
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
                @endforeach
                
            </div>
            <div align='center'>
                {{ $courses->links() }}
            </div>
        </div>
    </div>
@stop

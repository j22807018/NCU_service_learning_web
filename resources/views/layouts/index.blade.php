@extends('layouts.layout')

@section('js_css')
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div align='center'>
                {{ $courses->links() }}
            </div>
            <div class="table-responsive">
                @foreach($courses as $course)
                    <table style=" table-layout:fixed" class="table table-striped table-bordered" align="center" valign="middle">

                        <tr height="50px" style="border-style:double">
                            <td align='center' class="col-md-1">使用對象{{$course->id}}</td>
                            <td align='center' class="col-md-1">
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
                            <td align='center' class="col-md-1">資料公告日期</td>
                            <td align='center' class="col-md-1">{{ $course->created_at->toDateString() }}</td>

                            <td align='center' class="col-md-1" style= "word-break:break-all" width="100px">
                                @if(auth()->check() && auth()->user()->isAdmin() ) 
                                    <div class="dropdown">
                                      <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">後臺操作<span class="caret"></span>
                                      </button>
                                      <ul class="dropdown-menu" >
                                        <li><a href="{{URL::route('course.edit', $course->id)}}">內容修改</a></li>
                                      <!--   <li class="btn btn-primary btn-block btn-file">
                                            <span>檔案上傳</span><input id="upload_file" type="file" class="file">
                                        </li> -->
                                        <li><a data-method="delete" href="{{URL::route('course.destroy', $course->id)}}">整筆刪除</a></li>
                                      </ul>
                                    </div>
                                @endif
                            </td>
                        </tr>
                        
                        <tr style="border-style:double">
                            <td align='center' class="col-md-1">教學內容與使用建議</td>
                            <td colspan="3">
                                <p>標題：{{ $course->title }}</p>
                                <p>內文：{{ $course->message }}</p>
                            </td>
                            <td align='center' class="col-md-1" style="padding:10px">
                                @if(auth()->check() && auth()->user()->isAdmin() )
                                    {{ Form::open(['route' => ['file.upload', $course->id], 'enctype' => 'multipart/form-data']) }}
                                        <div class="checkbox">
                                            <input name="is_login_need" type="hidden" value="0">
                                            <input name="is_login_need" type="checkbox" value="1">僅限中大portal帳號
                                        </div>
                                        <input id="{{$course->id}}" name="upload_file[]" type="file" class="file-loading">
                                    {{ Form::close() }}
                                @endif
                            </td>

                        </tr>

                
                        @foreach($course->files as $file)
                            <tr style="border-style:double">
                                <td align='center'>檔案</td>
                                <td align='center'> 
                                    <a href="{{ URL::route('file.download', $file->id) }}">{{ $file->title }}
                                </td>
                                <td align='center'>
                                    <p>下載次數</p>
                                </td>
                                <td>
                                    <p>{{ $file->download_times }}</p>
                                </td>
                                <td align='center'>
                                    <p>
                                    @if($file->is_login_need)
                                        僅限中大portal帳號
                                    @else
                                        不限
                                    @endif
                                    </p>
                                </td>
                            </tr>
            <!--                <a href="{{ URL::to('') }}"><img src="{{asset('')}}"> -->
                        @endforeach
                    </table>    
                @endforeach
                
            </div>
            <div align='center'>
                {{ $courses->links() }}
            </div>
        </div>
    </div>
@stop

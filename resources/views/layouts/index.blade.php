@extends('layouts.layout')

@section('js_css')
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table style="width:100%" class="table">
                    @foreach($courses as $course)

                        <tr>
                            <th>使用對象{{$course->id}}</th>
                            <th></th>
                            <th>資料公告日期</th>
                            <th>{{ $course->updated_at }}</th>
                            <th>
                                @if($course->is_for_student)
                                    <p>student</p>
                                @endif
                                @if($course->is_for_teacher)
                                    <p>teacher</p>
                                @endif
                                @if($course->is_for_staff)
                                    <p>staff</p>
                                @endif
                            </th>

                            <th>
                                <div class="dropdown">
                                  <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">後臺操作<span class="caret"></span>
                                  </button>
                                  <ul class="dropdown-menu" >
                                    <li><a href="{{URL::route('course.edit', $course->id)}}">內容修改</a></li>
                                    <li><a href="#">檔案上傳</a></li>
                                    <li><a href="{{URL::route('course.destroy', $course->id)}}">整筆刪除</a></li>
                                    <li><a href="#">瀏覽權限管理</a></li>
                                  </ul>
                                </div>
                            </th>
                        </tr>
                        
                        <tr>
                            <td>教學內容與使用建議</td>
                            <td>
                                <p>標題：{{ $course->title }}</p>
                                <p>{{ $course->message }}</p>
                            </td>               
                        </tr>
                        @foreach($course->files as $file)
                            <tr>
                                <td>檔案</td>
                                <td>
            <!--                        <a href="{{ URL::to('') }}"><img src="{{asset('')}}">
                                </td>
                                <td>
                                    <p>下載次數</p>
                                </td>
                                <td>
                                    <p>{{ $file->download_times }}</p>
                                </td>
                                <td>瀏覽權限</td>
                                <td>
                                  <!--   @if($file->is_login_need)
                                        <p>僅限中大portal帳號</p>
                                    @else
                                        <p>不限</p>
                                    @endif -->
                                </td>
                            </tr>
            <!--                <a href="{{ URL::to('') }}"><img src="{{asset('')}}"> -->
                        @endforeach
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@stop

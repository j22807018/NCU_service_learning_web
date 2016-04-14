@extends('layouts.layout')

@section('js_css')
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h2 class="page-header">課程列表</h2>
            <div align='center'>
                {{ $courses->links() }}
            </div>
            
            <div class="table-responsive img-rounded" style="padding-bottom:35px">
                <table class="table table-striped" style="table-layout:fixed; margin-bottom:0px" align="center" valign="middle">
                    <thead style="background-color:DEEEFF;">
                        <tr>
                            <td align='center' style="font-weight:bolder">
                                <div class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="color:black">課程分類<span class="caret"></span></a>
                                    <ul class="dropdown-menu" >
                                      <li><a href="{{URL::route('course.index')}}">所有課程</a></li>
                                      <li><a href="{{URL::route('course.index', ['user' => 'for-student'])}}">學生自主服務</a></li>
                                      <li><a href="{{URL::route('course.index', ['user' => 'not-for-student'])}}">服務學習課程</a></li>
                                    </ul>
                                </div>
                            </td>
                            <td align='center' style="font-weight:bolder"><p>公告日期</p></td>
                            <td align='center' style="font-weight:bolder" colspan="4"><p>課程標題</p></td>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($courses as $course)
                        <tr>
                            <td align='center'>
                                <p>
                                    @if($course->is_for_student)
                                        學生自主服務
                                    @else
                                        服務學習課程
                                    @endif
                                </p>
                            </td>
                            <td align='center'>
                                {{ $course->created_at->toDateString() }}
                            </td>
                            <td colspan="4" style="word-break:break-word;">
                                @if(!$course->is_announced)
                                    <p>【尚未公告】</p>
                                @endif
                                <a href="{{URL::route('course.show', $course->id)}}">
                                    {{ $course->title }}
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div align='center'>
                {{ $courses->links() }}
            </div>
        </div>
    </div>
@stop

@extends('layouts.layout')

@section('content')
    <div style="padding:30px; margin-bottom:30px;">

        @if (isset($course->id))
            {{ Form::model($course, array('route' => array('course.update', $course->id), 'method' => 'put')) }}
        @else
            {{ Form::model($course, array('route' => 'course.store')) }}
        @endif
        <div class="form-horizontal">
            <div class="form-group" >
                <label class="col-sm-2 control-label">標題</label>
                <div class="col-sm-4">
                    <input name="title" type="text" class="form-control" value="{{{ $course->title }}}">
                </div>

                <label class="col-sm-2 control-label">使用對象</label>
                <div class="col-sm-4">
                    <input name="is_for_student" type="hidden" value="0">
                    <input name="is_for_teacher" type="hidden" value="0">
                    <input name="is_for_staff" type="hidden" value="0">
                    @if ($course->is_for_student)
                        <input name="is_for_student" type="checkbox" checked class="form-control" value="1">學生
                    @else
                        <input name="is_for_student" type="checkbox" class="form-control" value="1">學生
                    @endif

                    @if ($course->is_for_teacher)
                        <input name="is_for_teacher" type="checkbox" checked class="form-control" value="1">老師
                    @else
                        <input name="is_for_teacher" type="checkbox" class="form-control" value="1">老師
                    @endif

                    @if ($course->is_for_staff)
                        <input name="is_for_staff" type="checkbox" checked class="form-control" value="1">員工
                    @else
                        <input name="is_for_staff" type="checkbox" class="form-control" value="1">員工
                    @endif

                </div>
                
            </div>
            <div class="form-group" >
                <label class="col-sm-2 control-label">內容</label>
                <div class="col-sm-4">
                    <input name="message" type="text" class="form-control" value="{{{ $course->message }}}">
                </div>              
            </div>
            @if (isset($course->id))
                <button type="submit" class="col-sm-offset-10 col-sm-2 btn btn-primary ">修改</button>
            @else
                <button type="submit" class="col-sm-offset-10 col-sm-2 btn btn-primary ">創建</button>
            @endif
        </div>
        {{ Form::close() }}
    </div>
    @if($errors->all() != null)
        <div class="alert alert-danger">
        @foreach ($errors->all() as $message)
            <p>{{{ $message }}}</p>
        @endforeach
        </div>
    @endif
@stop
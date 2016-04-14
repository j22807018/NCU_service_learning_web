@extends('layouts.layout')

@section('content')
    <div class="col-md-8 col-md-offset-2" style="margin-bottom:30px;">
        @if (isset($course->id))
            <h2 class="page-header">修改課程</h2>
        @else
            <h2 class="page-header">新增課程</h2>
        @endif
        <div class="form-horizontal well well-lg">
            @if (isset($course->id))
                {{ Form::model($course, array('route' => array('course.update', $course->id), 'method' => 'put')) }}
            @else
                {{ Form::model($course, array('route' => 'course.store')) }}
            @endif
        
            <div class="form-group" style="padding-top:30px">
                <label class="col-sm-3 control-label">課程標題</label>
                <div class="col-sm-8">
                    <input name="title" type="text" class="form-control" value="{{{ $course->title }}}">
                </div>
            </div>
            <div class="form-group" >
                <label class="col-sm-3 control-label">使用對象</label>
                <div class="col-sm-8">
                    <input name="is_for_student" type="hidden" value="0">
                    <input name="is_for_teacher" type="hidden" value="0">
                    <input name="is_for_staff" type="hidden" value="0">
                    <div class="checkbox">
                        @if ($course->is_for_student)
                            <label class="col-sm-4">
                                <input name="is_for_student" type="checkbox" checked value="1">學生
                            </label>                    
                        @else
                            <label class="col-sm-4">
                                <input name="is_for_student" type="checkbox" value="1">學生
                            </label>                    
                        @endif

                        @if ($course->is_for_teacher)
                            <label class="col-sm-4">
                                <input name="is_for_teacher" type="checkbox" checked value="1">老師
                            </label>                    
                        @else
                            <label class="col-sm-4">
                                <input name="is_for_teacher" type="checkbox" value="1">老師
                            </label>                    
                        @endif

                        @if ($course->is_for_staff)
                            <label class="col-sm-4">
                                <input name="is_for_staff" type="checkbox" checked value="1">職員
                            </label>                    
                        @else
                            <label class="col-sm-4">
                                <input name="is_for_staff" type="checkbox" value="1">職員
                            </label>
                        @endif
                    </div>
                </div>
            </div>

            <div class="form-group" >
                <label class="col-sm-3 control-label">瀏覽權限</label>
                <div class="col-sm-8">
                    <input name="is_login_need" type="hidden" value="0">
                    <div class="checkbox">
                        <label>
                            @if ($course->is_login_need)
                                <input name="is_login_need" type="checkbox" checked value="1">限中大portal帳號登入者
                            @else
                                <input name="is_login_need" type="checkbox" value="1">限中大portal帳號登入者
                            @endif
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group" >
                <label class="col-sm-3 control-label">課程說明</label>
                <div class="col-sm-8">
                    <textarea name="message" type="text" class="form-control" value="{{ $course->message }}" style="height:150px">{{ $course->message }}</textarea>
                </div>              
            </div>
            <div class="row">
                <div class="col-md-2 col-md-offset-3">
                    @if (isset($course->id))
                        <button type="submit" class="btn btn-primary btn-lg">修改</button>
                    @else
                        <button type="submit" class="btn btn-primary btn-lg">創建</button>
                    @endif
                </div>
                <div class="col-md-2 col-md-offset-2">
                    <a href="{{URL::route('course.index')}}"  class="btn btn-primary btn-lg">返回</a>
                </div>
            </div>
            {{ Form::close() }}


            @if($errors->all() != null)
                <div class="alert alert-danger col-sm-8 col-sm-offset-2">
                @foreach ($errors->all() as $message)
                    <p>{{{ $message }}}</p>
                @endforeach
                </div>
            @endif
        </div>
        
    </div>
    
@stop
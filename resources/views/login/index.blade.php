@extends('layouts.layout')

@section('content')
    <div class="row">
        <div class="col-md-5">
            {{ Form::open(array('action' => 'HomeController@login', 'style' => 'max-width: 330px;')) }}

            <div class="form-group">
                {{ Form::label('portalId', 'portal帳號:') }}
                {{ Form::text('portalId', '', array('class' => 'form-control')) }}
            </div>

            <div class="form-group">
                {{ Form::label('password', '密碼:') }}
                {{ Form::password('password',  array('class' => 'form-control')) }}
            </div>

            {{ Form::submit('登入', array('class' => 'btn btn-primary')) }}
            {{ Form::close() }}
        </div>
    </div>


	@foreach ($errors->all() as $message)
		{{ $message }}
	@endforeach
@stop
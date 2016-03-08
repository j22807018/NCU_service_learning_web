@extends('layouts.layout')

@section('js_css')
	{{ HTML::style('css/border.css') }}
	{{ HTML::style('css/homepage.css')}}
@stop

@section('content')
    <table style="width:100%">
        @foreach($courses as $course)
            <tr>
                <th>使用對象</th>
                <th></th>
                <th>資料公告日期</th>
                <th>{{ $course->updated_at }}</th>
                @if()
                    <th></th>
                @endif
                
            </tr>
            
            <tr>
                <td>教學內容與使用建議</td>
                <td>
                    <p>標題：{{ $course->title }}</p>
                    <p>{{ $course->message }}</p>
                </td>               
            </tr>
            @foreach($course->$files as $file)
                <tr>
                    <td>檔案</td>
                    <td>
                        <a href="{{ URL::to('') }}"><img src="{{asset('')}}">
                    </td>
                    <td>
                        <p>下載次數</p>
                    </td>
                    <td>
                        <p>{{$file->download_times}}</p>
                    </td>
                    <td>瀏覽權限</td>
                    <td>
                        @if($file->is_login_need)
                            <p>僅限中大portal帳號</p>
                        @else
                            <p>不限</p>
                        @endif
                    </td>
                </tr>
                <a href="{{ URL::to('') }}"><img src="{{asset('')}}">
            @endforeach
        @endforeach
    </table>

@stop

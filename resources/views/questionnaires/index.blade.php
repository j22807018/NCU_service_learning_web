@extends('layouts.layout')

@section('js_css')
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h2 class="page-header">問卷統計</h2>
            <div align='center'>
                {{ $courses->links() }}
            </div>
            <div class="table-responsive img-rounded">
                <table class="table table-striped" style="table-layout:fixed" align="center" valign="middle">
                    <thead style="background-color:DEEEFF;">
                        <tr >
                            <td align='center' style="font-weight:bolder" colspan="4"><p>課程標題</p></td>
                            <td align='center' style="font-weight:bolder"><p>喜歡</p></td>
                            <td align='center' style="font-weight:bolder"><p>普通</p></td>
                            <td align='center' style="font-weight:bolder"><p>內容需要修改</p></td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($courses as $course)
                            <tr >
                                <td colspan="4">
                                    <a href="{{URL::route('questionnaire.show', $course->id)}}" style="word-break:break-word; ">{{ $course->title }}</a>
                                </td>
                                <td align='center'><p>{{ $course->questionnaires->where('satisfaction', 1)->count() }}</p></td>
                                <td align='center'><p>{{ $course->questionnaires->where('satisfaction', 2)->count() }}</p></td>
                                <td align='center'><p>{{ $course->questionnaires->where('satisfaction', 3)->count() }}</p></td>
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

@extends('layouts.layout')

@section('js_css')
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div align='center'>
                {{ $questionnaires->links() }}
            </div>
            <div class="table-responsive">
                @if(count($questionnaires) == 0)
                    <table class="table table-bordered" style="table-layout:fixed; margin-bottom:0px; background-color:#f9f9f9" align="center" valign="middle">
                        <tr style="border-style:double">
                            <td align='center' style="font-weight:bolder">尚無問卷</td>
                        </tr>
                    </table>
                @else
                    <table class="table table-bordered table-striped" style="table-layout:fixed" align="center" valign="middle">
                        @foreach($questionnaires as $questionnaire)
                            <tr style="border-style:double">
                                <td align='center' style="font-weight:bolder">填寫帳號</td>
                                <td align='center'>
                                    @if($questionnaire->user_id != 0)
                                        {{ $questionnaire->user->name }}
                                    @else
                                        無
                                    @endif
                                </td>
                                <td align='center' style="font-weight:bolder">課程ID</td>
                                <td align='center'><a href="{{URL::route('questionnaire.show', $questionnaire->course_id)}}">{{ $questionnaire->course_id }}</a></td>
                                <td align='center' style="font-weight:bolder">滿意度</td>
                                <td align='center'>
                                    @if($questionnaire->satisfaction == 1)
                                        喜歡
                                    @elseif($questionnaire->satisfaction == 2)
                                        普通
                                    @elseif($questionnaire->satisfaction == 3)
                                        內容需要修改
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </table>
                @endif
            </div>
            <div align='center'>
                {{ $questionnaires->links() }}
            </div>
        </div>
    </div>
@stop

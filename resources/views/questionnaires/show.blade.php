@extends('layouts.layout')

@section('js_css')
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h2 class="page-header">問卷詳細資料</h2>
            <div align='center'>
                {{ $questionnaires->links() }}
            </div>
            <div class="table-responsive img-rounded">
                @if(count($questionnaires) == 0)
                    <table class="table" style="table-layout:fixed;" align="center" valign="middle">
                        <thead style="background-color:DEEEFF;">
                            <tr>
                                <td align='center' style="font-weight:bolder"><p>尚無問卷</p></td>
                            </tr>
                        </thead>
                    </table>
                @else
                    <table class="table table-striped" style="table-layout:fixed" align="center" valign="middle">    
                        <thead style="background-color:DEEEFF;">
                            <tr>
                                <td align='center' style="font-weight:bolder" colspan="1">
                                    <p>課程標題</p>
                                </td>
                                <td style="word-break:break-word; " colspan="3">
                                    <p>{{$questionnaires[0]->course->title}}</p>
                                </td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($questionnaires as $questionnaire)
                                <tr>
                                    <td align='center' style="font-weight:bolder"><p>填寫帳號</p></td>
                                    <td align='center'><p>
                                        @if($questionnaire->user_id != 0)
                                            {{ $questionnaire->user->name }}
                                        @else
                                            無
                                        @endif
                                    </p></td>
                                    
                                    <td align='center' style="font-weight:bolder"><p>滿意度</p></td>
                                    <td align='center'><p>
                                        @if($questionnaire->satisfaction == 1)
                                            喜歡
                                        @elseif($questionnaire->satisfaction == 2)
                                            普通
                                        @elseif($questionnaire->satisfaction == 3)
                                            內容需要修改
                                        @endif
                                    </p></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
            <div align='center'>
                {{ $questionnaires->links() }}
            </div>
        </div>
    </div>
@stop

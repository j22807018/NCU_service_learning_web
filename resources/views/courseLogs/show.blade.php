@extends('layouts.layout')

@section('js_css')
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h2 class="page-header">課程內容修改紀錄</h2>
            <div align='center'>
                {{ $logs->links() }}
            </div>
            @if(count($logs) == 0)
                <div  class="table-responsive img-rounded">
                    <table class="table" style="table-layout:fixed; margin-bottom:0px; background-color:#f9f9f9" align="center" valign="middle">
                        <thead>
                            <tr style="background-color:DEEEFF;">
                                <td align='center' style="font-weight:bolder"><p>無修改紀錄</p></td>
                            </tr>
                        </thead>
                    </table>
                </div>
            @else
                @foreach($logs as $log)
                    <div  class="table-responsive img-rounded">
                        <?php  $modifications = json_decode( $log->modifications, true); ?>
                        <table class="table" style="table-layout:fixed;" align="center" valign="middle">
                            <thead>
                                <tr style="background-color:DEEEFF;">
                                    <td align='right' colspan="3"><p>修改日期：{{ $modifications['update_time'] }}</p></td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="background-color:#f9f9f9">
                                    <td align='center' style="font-weight:bolder"><p>修改欄位</p></td>
                                    <td align='center' style="font-weight:bolder"><p>修改前</p></td>
                                    <td align='center' style="font-weight:bolder"><p>修改後</p></td>
                                </tr>
                            
                                @if($modifications['user_origin'] != null)
                                    <tr>
                                        <td align='center'>使用對象</td>
                                        <td align='center'>{{ $modifications['user_origin'] }}</td>
                                        <td align='center'>{{ $modifications['user_new'] }}</td>
                                    </tr>
                                @endif
                                @if($modifications['title_origin'] != null)
                                    <tr>
                                        <td align='center'>課程標題</td>
                                        <td style="word-break:break-word;">{{ $modifications['title_origin'] }}</td>
                                        <td style="word-break:break-word;">{{ $modifications['title_new'] }}</td>
                                    </tr>
                                @endif
                                @if($modifications['message_origin'] != null)
                                    <tr>
                                        <td align='center'>課程說明</td>
                                        <td style="word-break:break-word; white-space:pre-line;">{{ $modifications['message_origin'] }}</td>
                                        <td style="word-break:break-word; white-space:pre-line;">{{ $modifications['message_new'] }}</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                @endforeach
            @endif
            <div align='center'>
                {{ $logs->links() }}
            </div>
        </div>
    </div>
@stop

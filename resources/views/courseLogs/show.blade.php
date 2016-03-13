@extends('layouts.layout')

@section('js_css')
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div align='center'>
                {{ $logs->links() }}
            </div>
            <div class="table-responsive">
                @if(count($logs) == 0)
                    <table class="table table-bordered" style="table-layout:fixed; margin-bottom:0px; background-color:#f9f9f9" align="center" valign="middle">
                        <tr style="border-style:double">
                            <td align='center' style="font-weight:bolder">無修改紀錄</td>
                        </tr>
                    </table>
                @else
                    @foreach($logs as $log)
                        <?php  $modifications = json_decode( $log->modifications, true); ?>
                        <table class="table table-bordered" style="table-layout:fixed; margin-bottom:0px; background-color:#f9f9f9" align="center" valign="middle">
                            <tr style="border-style:double">
                                <td align='right' colspan="3">修改日期：{{ $modifications['update_time'] }}</td>
                            </tr>
                        </table>
                        <table class="table table-bordered" style="table-layout:fixed" align="center" valign="middle">
                            
                            <tr style="border-style:double; background-color:#f9f9f9">
                                <td align='center' style="font-weight:bolder">修改欄位</td>
                                <td align='center' style="font-weight:bolder">修改前</td>
                                <td align='center' style="font-weight:bolder">修改後</td>
                            </tr>
                            @if($modifications['user_origin'] != null)
                                <tr style="border-style:double">
                                    <td align='center'>使用對象</td>
                                    <td align='center'>{{ $modifications['user_origin'] }}</td>
                                    <td align='center'>{{ $modifications['user_new'] }}</td>
                                </tr>
                            @endif
                            @if($modifications['title_origin'] != null)
                                <tr style="border-style:double">
                                    <td align='center'>標題</td>
                                    <td align='center'>{{ $modifications['title_origin'] }}</td>
                                    <td align='center'>{{ $modifications['title_new'] }}</td>
                                </tr>
                            @endif
                            @if($modifications['message_origin'] != null)
                                <tr style="border-style:double">
                                    <td align='center'>內文</td>
                                    <td align='center'>{{ $modifications['message_origin'] }}</td>
                                    <td align='center'>{{ $modifications['message_new'] }}</td>
                                </tr>
                            @endif
                        </table>
                    @endforeach
                @endif
            </div>
            <div align='center'>
                {{ $logs->links() }}
            </div>
        </div>
    </div>
@stop

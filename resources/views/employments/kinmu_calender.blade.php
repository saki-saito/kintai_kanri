@extends('layouts.app')

@section('content')
    
    <div class="row">
        <div class="col-sm-10 m-auto">
            <table class="table bg-primary">
                <tr>
                    <td class="text-white text-right align-middle">
                        <a href="{!! route('emp.kinmu_calender', ['user_id' => Auth::id(), 'ym' => $ym_bk]) !!}">
                            <i class="far fa-caret-square-left fa-lg fa-inverse"></i>
                        </a>
                    </td>
                    <td class="text-white text-center align-middle">
                        {!! $ym !!}
                    </td>
                    <td class="text-white text-left align-middle">
                        <a href="{!! route('emp.kinmu_calender', ['user_id' => Auth::id(), 'ym' => $ym_nxt]) !!}">
                            <i class="far fa-caret-square-right fa-lg fa-inverse"></i>
                        </a>
                    </td>
                </tr>
            </table>
            <table class="table table-striped table-bordered">
                <tr>
                    <th class="text-center align-middle">日付<br>（曜日）</th>
                    <th class="text-center align-middle">勤務実績</th>
                    <th class="text-center align-middle">出勤時刻</th>
                    <th class="text-center align-middle">退勤時刻</th>
                </tr>
                @foreach ($kinmus as $kinmu)
                    <tr>
                        <td class="text-center align-middle">
                            {!! $kinmu['d'] !!}<br>{!! $kinmu['dayofweek'] !!}
                        </td>
                        
                        @if (is_null($kinmu['kinmu_komoku']))
                            <td class="text-center align-middle">
                                @if ($kinmu['day_kubun'] == 1)
                                    <button type="button" class="btn btn-danger" disabled="disabled">休日</button>
                                @endif
                            </td>
                            <td class="text-center align-middle">
                            </td>
                            <td class="text-center align-middle">
                            </td>
                        @else
                            <td class="text-center align-middle">
                                <button type="button" class="btn btn-success" disabled="disabled">{!! $kinmu['kinmu_komoku']->kinmu_name !!}</button>
                            </td>
                            <td class="text-center align-middle">
                                @if (!is_null($kinmu['kanni_kinmu_start']))
                                    {!! $kinmu['kanni_kinmu_start']->kanni_kinmu_start_time !!}
                                @else
                                    {!! $kinmu['kinmu_komoku']->syotei_start_time !!}
                                @endif
                            </td>
                            <td class="text-center align-middle">
                                @if (!is_null($kinmu['kanni_kinmu_end']))
                                    {!! $kinmu['kanni_kinmu_end']->kanni_kinmu_end_time !!}
                                @else
                                    {!! $kinmu['kinmu_komoku']->syotei_end_time !!}
                                @endif
                            </td>
                        @endif
                    </tr>
                @endforeach
            </table>
        </div>
    </div>

@endsection
@extends('layouts.app')

@section('content')

<?php
    /* ----------------------------------------------- *
     * 'ymd_fmt' => $ymd_fmt,
     * 'dayofweek' => $dayofweek,
     * 'kinmu_komokus' => $kinmu_komokus,
     * 'kinmu_toroku' => $kinmu_toroku,
     * 'kanni_kinmu_start' => $kanni_kinmu_start,
     * 'kanni_kinmu_end' => $kanni_kinmu_end,
     * 'jikangai_toroku' => $jikangai_toroku,
     * ----------------------------------------------- */
?>
    
    <script>
        function clickBtn1(){
            
    	    const color1 = document.form1.color1;
            
    	    // 値(数値)を取得
    	    const num = color1.selectedIndex;
    	    //const num = document.form1.color1.selectedIndex;
        
	        // 値(数値)から値(value値)を取得
            const str = color1.options[num].value;
	        //const str = document.form1.color1.options[num].value;
    
    	    document.getElementById("span1").textContent = str; 
        }
    </script>
    
    <div class="row">
        <div class="col-sm-10 m-auto">
            
            {!! Form::open() !!}
            
            <table class="table table-borderless">
                <tr>
                    <td class="text-left align-middle">
                        {{-- 日付 --}}
                        <p>{{ $ymd_fmt.$dayofweek }}</p>
                    </td>
                    <td class="text-right align-middle">
                        {{-- 登録ボタン --}}
                        {!! Form::submit('登録', ['class' => 'btn btn-primary']) !!}
                    </td>
                </tr>
            </table>
            
            {{-- タブ --}}
            @include('employments.syosai_kinmu_navtabs')
            
            {{-- 入力フォーム --}}
            <div class="tab-content pt-3">
                {{-- 勤務内容 --}}
                <div id="naiyo" class="tab-pane active ">
                    <div class="row ">
                        <div class="col-sm-11 m-auto border py-3 px-4">
                            
                            <table class="table table-borderless m-0">
                                <tr class="d-flex">
                                    <td class="col-5">勤務内容</td>
                                    <td class="col-7">
                                        <div class="form-row justify-content-left">
                                            <div class="col-sm-12">
                                                <select class="form-control">
                                                    @if (count($kinmu_komokus) > 0)
                                                        @foreach($kinmu_komokus as $kinmu_komoku)
                                                            @if (!is_null($kinmu_toroku))
                                                                {{-- この日の勤務登録があればその勤務登録の勤務内容にselectedをつける --}}
                                                                <option value="{{ $kinmu_komoku->id }}" {{ $kinmu_toroku->kinmu_komoku_id == $kinmu_komoku->id ? 'selected' : '' }}>{{ $kinmu_komoku->kinmu_name }}</option>
                                                            @else
                                                                <option value="{{ $kinmu_komoku->id }}" >{{ $kinmu_komoku->kinmu_name }}</option>
                                                            @endif
                                                        @endforeach
                                                    @else
                                                        <option value=""></option>
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="d-flex">
                                    <td class="col-5">かんたん登録時間</td>
                                    <td class="col-7">
                                        @if (!is_null($kanni_kinmu_start))
                                            {{ My_func::fromHisToHi($kanni_kinmu_start->kanni_kinmu_start_time) }}
                                        @else
                                            <button type="button" class="btn btn-outline-secondary btn-sm" disabled="disabled">未登録</button>
                                        @endif
                                        &nbsp;～&nbsp;
                                        @if (!is_null($kanni_kinmu_end))
                                            {{ My_func::fromHisToHi($kanni_kinmu_end->kanni_kinmu_end_time) }}
                                        @else
                                            <button type="button" class="btn btn-outline-secondary btn-sm" disabled="disabled">未登録</button>
                                        @endif
                                    </td>
                                </tr>
                                <tr class="d-flex">
                                    <td class="col-5">所定時間</td>
                                    <td class="col-7">09:00:00&nbsp;～&nbsp;17:00:00</td>
                                </tr>
                                <tr class="d-flex">
                                    <td class="col-5">所定休憩時間</td>
                                    <td class="col-7">12:00:00&nbsp;～&nbsp;13:00:00</td>
                                </tr>
                            </table>
                            
                        </div>
                    </div>
                </div>
                {{-- 時間外 --}}
                <div id="jikangai" class="tab-pane">
                    <div class="row ">
                        <div class="col-sm-11 m-auto border p-4">
                            
                            <table class="table table-borderless m-0">
                                <tr class="d-flex">
                                    <td class="col-5">時間外時間</td>
                                    <td class="col-7">
                                        <div class="form-row justify-content-left">
                                            <div class="col-sm-5">
                                                <input type="time" name="jikanngai_start" class="form-control">
                                            </div>
                                            <div class="col-sm-1 text-center align-middle">
                                                ～
                                            </div>
                                            <div class="col-sm-5">
                                                <input type="time" name="jikanngai_end" class="form-control">
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="d-flex">
                                    <td class="col-5">時間外理由</td>
                                    <td class="col-7">
                                        {!! Form::text('', null, ['class' => 'form-control']) !!}
                                    </td>
                                </tr>
                                <tr class="d-flex">
                                    <td class="col-5">時間外休憩</td>
                                    <td class="col-7">
                                        <div class="form-row justify-content-left">
                                        <div class="col-sm-5">
                                            <input type="time" name="jikanngai_kyukei_start" class="form-control">
                                        </div>
                                        <div class="col-sm-1 text-center align-middle">
                                            ～
                                        </div>
                                        <div class="col-sm-5">
                                            <input type="time" name="jikanngai_kyukei_end" class="form-control">
                                        </div>
                                    </div>
                                    </td>
                                </tr>
                            </table>
                            
                        </div>
                    </div>
                </div>
            </div>
            
            {!! Form::close() !!}
            
        </div>
    </div>

@endsection
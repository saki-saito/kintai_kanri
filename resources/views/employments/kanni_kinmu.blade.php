@extends('layouts.app')

@section('content')
    
    <div class="row">
        <div class="col-sm-6 align-self-center m-auto">
            @include('commons.clock')
        </div>
        @if(Auth::check())
            <div class="col-sm-6">
                
                {{-- 各機能へのリンク --}}
                <div class="row">
                    <div class="offset-sm-2 col-sm-8 my-auto pt-5">
                        {{-- 出勤 --}}
                        {!! Form::open(['route' => 'emp.kanni_kinmu_start', 'method' => 'post']) !!}
                            {!! Form::hidden('user', Auth::user()) !!}
                            {!! Form::hidden('kinmu_komoku_id', $kinmu_komoku->id) !!}
                            {!! Form::hidden('ymd', '') !!}
                            @if(!$kanni_kinmu_start['check'])
                                {!! Form::button('<i class="fas fa-star"></i>　出勤', ['class' => 'btn btn-outline-danger btn-block btn-lg', 'type' => 'submit']) !!}
                            @else
                                {!! Form::button('<i class="fas fa-star"></i>　出勤済', ['class' => 'btn btn-danger btn-block btn-lg disabled']) !!}
                                <?php
                                    // TODO あとでデザインする
                                    echo $kinmu_komoku->kinmu_name;
                                    echo $kanni_kinmu_start['ymd'].$kanni_kinmu_start['dayofweek'];
                                    echo $kanni_kinmu_start['time'];
                                ?>
                            @endif
                        {!! Form::close() !!}
                        
                    </div>
                    
                    <div class="offset-sm-2 col-sm-8 my-auto pt-5">
                        {{-- 退勤 --}}
                        {!! Form::open(['route' => 'emp.kanni_kinmu_end', 'method' => 'post']) !!}
                            {!! Form::hidden('user', Auth::user()) !!}
                            {!! Form::hidden('kinmu_komoku_id', $kinmu_komoku->id) !!}
                            {!! Form::hidden('ymd', '') !!}
                            @if(!$kanni_kinmu_end['check'])
                                {!! Form::button('<i class="fas fa-star"></i>　退勤', ['class' => 'btn btn-outline-primary btn-block btn-lg', 'type' => 'submit']) !!}
                            @else
                                {!! Form::button('<i class="fas fa-star"></i>　退勤済', ['class' => 'btn btn-primary btn-block btn-lg disabled']) !!}
                                <?php
                                    // TODO あとでデザインする
                                    echo $kinmu_komoku->kinmu_name;
                                    echo $kanni_kinmu_end['ymd'].$kanni_kinmu_end['dayofweek'];
                                    echo $kanni_kinmu_end['time'];
                                ?>
                            @endif
                        {!! Form::close() !!}
                    </div>
                    
                </div>
            </div>
        @endif
    </div>

@endsection
@extends('layouts.app')

@section('content')
    
    <!--はいけいとけい-->
    <!--<div class="row">-->
    <!--    <div class="offset-sm-1 col-sm-10 my-auto clock">-->
    <!--        {{-- 時間の表示 --}}-->
    <!--        <div id="degitalClockYmd"></div>-->
    <!--        <div id="degitalClockTime"></div>-->
    <!--    </div>-->
    <!--</div>-->
    
    <div class="row">
        <div class="col-sm-6 align-self-center m-auto">
            <div class="row">
                <div class="col-sm-12 my-auto text-center clock">
                    {{-- 時間の表示 --}}
                    <div id="degitalClockYmd"></div>
                    <div id="degitalClockTime"></div>
                </div>
            </div>
        </div>
        @if(Auth::check())
            <div class="col-sm-6">
                
                {{-- 各機能へのリンク --}}
                <div class="row">
                    
                    <div class="offset-sm-2 col-sm-8 my-auto pt-5">
                        {{-- 就業ボタンのフォーム --}}
                        {!! Form::open() !!}
                            {!! Form::button('<i class="fas fa-tasks"></i>　就業', ['class' => 'btn btn-outline-danger btn-block btn-lg', 'type' => 'submit']) !!}
                        {!! Form::close() !!}
                    </div>
                    
                    <div class="offset-sm-2 col-sm-8 my-auto pt-5">
                        {{-- ログアウト --}}
                        <a href="{!! route('logout.get') !!}" class="btn btn-outline-primary btn-block btn-lg">
                            <i class="fas fa-sign-out-alt"></i>　ログアウト
                        </a>
                    </div>
                    
                </div>
            </div>
        @endif
    </div>

@endsection
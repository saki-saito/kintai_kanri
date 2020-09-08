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
                        {{-- 勤怠入力メニューのリンク --}}
                        <a href="#" class="btn btn-outline-danger btn-block btn-lg">
                            <i class="fas fa-tasks"></i>　勤怠入力
                        </a>
                    </div>
                    
                    <div class="offset-sm-2 col-sm-8 my-auto pt-5">
                        {{-- 詳細勤務入力メニューのリンク --}}
                        <a href="#" class="btn btn-outline-primary btn-block btn-lg">
                            <i class="fas fa-tasks"></i>　詳細勤務入力
                        </a>
                    </div>
                    
                </div>
            </div>
        @endif
    </div>

@endsection
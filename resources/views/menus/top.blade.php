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
                        {{-- 就業メニューのリンク --}}
                        <a href="{!! route('menus.employment') !!}" class="btn btn-outline-danger btn-block btn-lg">
                            <i class="fas fa-tasks"></i>　就業
                        </a>
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
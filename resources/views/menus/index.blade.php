@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-sm-6">
            {{-- 時間の表示 --}}
        </div>
        <div class="col-sm-6">
            @if(Auth::check())
                
                {{-- 各機能へのリンク --}}
                
            @else
                
                {{-- サインインページへのリンク --}}
                <p class="mt-2">
                    {!! link_to_route('signup.get', 'Sign up') !!}
                </p>
                {{-- ログインページへのリンク --}}
            
            @endif
        </div>
        
    </div>



@endsection
<header class="mb-4">
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
        {{-- トップページへのリンク --}}
        <a class="navbar-brand" href="/">勤怠管理</a>
        
        <div class="collapse navbar-collapse" id="nav-bar">
            <ul class="navbar-nav mr-auto"></ul>
            <ul class="navbar-nav">
                @if (!Auth::check())
                    {{-- ユーザ登録ページへのリンク --}}
                    <li class="nav-item">{!! link_to_route('signup.get', 'Signup', [], ['class' => 'nav-link']) !!}</li>
                    {{-- ログインページへのリンク --}}
                    <li class="nav-item">{!! link_to_route('login.get', 'Login', [], ['class' => 'nav-link']) !!}</li>
                @else
                    {{-- ユーザー名 --}}
                    <li class="nav-item"><a href="#" class="nav-link">{{ Auth::user()->name }}</a></li>
                @endif
            </ul>
        </div>
    </nav>
</header>
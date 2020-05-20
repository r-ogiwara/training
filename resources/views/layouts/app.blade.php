<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet"><!--追加-->

    <!--郵便番号検索のため-->
    <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
    <!--カテゴリバリデーションのため-->
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <!--アイコン利用のため-->
    <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">

</head>
<body>
    <div id="wrapper">
        <header>
        </header>
        <div id="app">
            <nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm">
                <div class="container">
                    <!--<a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>-->
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">

                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item active">
                                <a class="nav-link" href="{{ route('home') }}">LOGO</a>
                            </li>
                        </ul>

                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ml-auto">
                            <!-- Authentication Links -->
                            @guest
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">ログイン</a>
                                </li>
                                <!--@if (Route::has('register'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                    </li>
                                @endif-->
                            @else
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('post') }}">投稿する</a>
                                </li>

                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        {{ Auth::user()->name }} <span class="caret"></span>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">

                                        <a class="dropdown-item" href="{{ route('account.index', ['id' => Auth::id()]) }}">
                                            アカウント情報
                                        </a>

                                        <a class="dropdown-item" href="{{ route('showChangePasswordForm') }}">
                                            パスワード変更
                                        </a>

                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                                            ログアウト
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </div>
                                </li>

                                <a class="showLink" href="{{ route('account.index', ['id' => Auth::id()]) }}">
                                <!--画像の存在チェック(あれば表示)-->
                                <?php
                                $id = Auth::id();
                                if(file_exists( "storage/account_images/${id}.png" )){
                                    echo "<img src='/storage/account_images/${id}.png' class='app_account_img'>";
                                }else{
                                    echo "<img src='/storage/images/アカウント初期画像.png' class='app_account_img'>";
                                }
                                ?>
                                </a>
                            @endguest
                        </ul>
                    </div>
                </div>
            </nav>

            <main class="py-4">
                @yield('content')
            </main>
        </div>
        <footer>
            <p class="footer-text">利用規約</p>
            <p class="footer-text">プライバシー</p>
            <p class="footer-text">ガイドライン</p>
        </footer>
        </div>
    </div>
</body>
</html>

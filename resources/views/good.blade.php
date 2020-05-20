@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">　　　　　　　　　　　　　　　　　　　　　　　　アカウント情報画面　　　　　　　　　　　　　　　　　
                    @if( Auth::id() == $user->id )<!--もしログインしているユーザーのアカウント画面だったら-->
                    <a class="btn btn-link" href="{{ route('account.edit', ['id' => Auth::id()]) }}">アカウント編集</a>
                    @endif
                </div>

                <!--投稿後のメッセージ-->
                @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif

                <div class="account-box" >
                    <br />
                    <!--画像の存在チェック(あれば表示)-->
                    <?php
                    $id = $user->id;
                    if(file_exists( "storage/account_images/${id}.png" )){
                        echo "<img src='/storage/account_images/${id}.png' class='account_img'>";
                    }else{
                        echo "<img src='/storage/images/アカウント初期画像.png' class='account_img'>";
                    }
                    ?>
                    <h4><span>@</span>{{ $user->name }}<h4>
                    <br />
                    {{ $user->introduction }}
                    <br />
                    <br />
                    <br />
                    投稿数　{{ $post_count }}　　　　　　　　　　
                    総Good数　{{ $total_like }}
                </div>
            </div>
        </div>
        <br />
        <br />
        <br />
        <br />
        <br />
        <br />
        <br />
        <br />
        <br />
        <br />
        <br />
        <br />
        <br />
        <br />
        <br />
        <br />
        <br />
        <br />
        <br />
        <br />
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Goodした投稿一覧　
                @if( Auth::id() == $user->id )<!--もしログインしているユーザーのアカウント画面だったら-->
                <a class="btn btn-link" href="{{ route('account.index', ['id' => Auth::id()]) }}">このユーザーの投稿一覧</a>
                @endif
                </div>
                <div class="container mt-4">
                    @if($post_count == 0)
                    <div class="center">
                        <h4>まだ投稿はありません</h4>
                    </div>
                    @else
                        @foreach ($posts as $post)
                            <div class="card mb-4">
                                <div class="card-body">
                                    <p class="card-text">
                                        <a class="showlink" href="{{ route('show', ['id' => $post->post_id]) }}"><img src="/storage/post_images/{{ $post->post_id }}.png" width="120px" height="120px"></a>
                                        <a class="showlink" href="{{ route('show', ['id' => $post->post_id]) }}">{{ $post->title }}</a><br />
                                        　　　　　　　　　by {{ $post->name }}　
                                        <!--画像の存在チェック(あれば表示)-->
                                        <?php
                                        $id = $post->user_id;
                                        if(file_exists( "storage/account_images/${id}.png" )){
                                            echo "<img src='/storage/account_images/${id}.png' class='app_account_img'>";
                                        }else{
                                            echo "<img src='/storage/images/アカウント初期画像.png' class='app_account_img'>";
                                        }
                                        ?>
                                        　　　　　　　　　{{ $post->created_at->format('Y/m/d G:i') }}　　　　　　　　　　<i class="fas fa-thumbs-up"></i>　{{ $post->like_count }}
                                    </p>
                                </div>
                            </div>
                        @endforeach

                    <div class="d-flex justify-content-center">
                        {{ $posts->links() }}
                    </div>
                    @endif
                </div>

            </div>
            <div class="form-group row mb-0">
                <div class="col-md-8 offset-md-10">
                    <button type="button" class="btn btn-primary" id="btn_return" onclick='location.href="{{ route('home') }}"'>トップへ</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

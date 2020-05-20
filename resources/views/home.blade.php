@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">一覧画面
                    <a class="btn btn-link" href="{{ route('rank') }}">人気ランキング</a>
                    <form method="POST" action="{{ route('home') }}">
                        @csrf
                        <input type="text" name="search" id="search" placeholder="&#xF002; 検索" class="form-control">
                    </form>
                </div>
                <!--投稿後のメッセージ-->
                @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif

                <div class="container mt-4">
                    @foreach ($posts as $post)
                        <div class="card mb-4">
                            <div class="card-body">
                                <p class="card-text">
                                        <a class="showlink" href="{{ route('show', ['id' => $post->post_id]) }}"><img src="/storage/post_images/{{ $post->post_id }}.png" width="120px" height="120px"></a>
                                        <a class="showlink" href="{{ route('show', ['id' => $post->post_id]) }}">{{ $post->title }}</a><br />
                                        <div class="info-box">
                                            by<a class="accountlink" href="{{ route('account.index', ['id' => $post->user_id]) }}"> {{ $post->name }}</a>　<a class="accountlink" href="{{ route('account.index', ['id' => $post->user_id]) }}">
                                            <!--画像の存在チェック(あれば表示)-->
                                            <?php
                                            $id = $post->user_id;
                                            if(file_exists( "storage/account_images/${id}.png" )){
                                                echo "<img src='/storage/account_images/${id}.png' class='app_account_img'>";
                                            }else{
                                                echo "<img src='/storage/images/アカウント初期画像.png' class='app_account_img'>";
                                            }
                                            ?>
                                            </a>　　　　　　　　　{{ $post->created_at->format('Y/m/d G:i') }}　　　　　　　　　　<i class="fas fa-thumbs-up"></i>　{{ $post->like_count }}
                                        </div>
                                </p>
                            </div>
                        </div>
                    @endforeach

                    <div class="d-flex justify-content-center">
                        {{ $posts->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

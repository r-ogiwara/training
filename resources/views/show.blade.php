@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">　　　　　　　　　　　　　　　　　　詳細画面　　　　　　　　　　　　
                    @if( Auth::id() == $post->user_id )<!--もしログインしているユーザーが投稿した作品だったら-->
                        <a class="btn btn-link" href="{{ route('edit',['id' => $post->post_id]) }}">編集</a>
                        <a class="btn btn-link" href="{{ route('destroy',['id' => $post->post_id]) }}" onclick="deletePost(this); return false;">削除</a>
                    @endif
                </div>

                <script>
                    function deletePost(e){
                        "use strict";
                        if(window.confirm('本当に削除しますか？')){
                            document.getElementById('delete_' + e.dataset.id).submit();
                        }else{
                            window.alert('キャンセルされました');
                            return false;
                        }
                    }
                </script>
                <!--投稿後のメッセージ-->
                @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif

                <div class="center">
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
                    </a>　　　　　　　　　　　　　　　　　　　　
                    @if($post->created_at == $post->updated_at)
                        {{ $post->created_at->format('Y/m/d G:i') }}投稿
                    @else
                        {{ $post->updated_at->format('Y/m/d G:i') }}更新
                    @endif　　　　　　　　　　　　　　　　　　　　　　　　　
                    <h1 class="card-title"> {{ $post->title }} </h1>

                    @foreach($selects as $select)
                    <h5 class="ribbon4">{{$select->categorie_name}}</h5>
                    @endforeach
                    <br />
                    <br />
                    <br />
                    <div class="relative">
                        <img src="/storage/images/額縁.png" width="100%" height="100%">
                        <img src="/storage/post_images/{{ $post->post_id }}.png" width="80%" height="80%" class="absolute">
                    </div><br />
                    <p class="card-text2">{{ $post->comment }}</p>
                </div>
            </div>
            <div class="col-md-8 offset-md-8">
                @if($user_like == 0)
                <button type="submit" class="btn btn-primary2" id="ajax">Good　<i class="fas fa-thumbs-up"></i> <span id="test">{{ $like_count }}</span></button>
                @else
                <button type="submit" class="btn btn-primary" id="ajax">Good　<i class="fas fa-thumbs-up"></i> <span id="test">{{ $like_count }}</span></button>
                @endif
            </div>
            <script>
            $(function() {
                $('#ajax').on('click', function(e) {
                    e.preventDefault();//コミットをブロックしておく
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: '{{ route('ajax.like',['id' => $post->post_id]) }}',
                        type: 'GET',
                    })
                    // Ajaxリクエスト成功時の処理
                    .done(function(data) {
                        if(data >= 0){
                            //成功　イイね数をVIEWに返す
                            $('#test').text(data);
                            //ボタンの色を切り替える
                            if( $('button').hasClass('btn btn-primary2')){
                                $('#ajax').removeClass('btn btn-primary2');
                                $('#ajax').addClass('btn btn-primary');
                            }else if( $('button').hasClass('btn btn-primary')){
                                $('#ajax').removeClass('btn btn-primary');
                                $('#ajax').addClass('btn btn-primary2');
                            }
                        }
                        else{
                            //ログインしていない
                            $('#test').text("するにはログインが必要です");
                        }
                    })
                    // Ajaxリクエストが失敗した場合
                    .fail(function(data) {
                        window.alert("送信中止");
                    });

                });
            });
            </script>
            <br />
            <br />
            <h5>コメント一覧</h5>
            <div class="kakomi-box3" >
            @if($cnt > 0)
                @foreach($comments as $comment)
                　　<span>@</span><a class="accountlink" href="{{ route('account.index', ['id' => $comment->create_user]) }}">{{ $comment->name }}</a>　<a class="accountlink" href="{{ route('account.index', ['id' => $comment->create_user]) }}">
                    <!--画像の存在チェック(あれば表示)-->
                    <?php
                    $id = $comment->create_user;
                    if(file_exists( "storage/account_images/${id}.png" )){
                        echo "<img src='/storage/account_images/${id}.png' class='app_account_img'>";
                    }else{
                        echo "<img src='/storage/images/アカウント初期画像.png' class='app_account_img'>";
                    }
                    ?>
                    </a>　　　　　　{{ $comment->created_at->format('Y/m/d G:i') }}
                    @if( Auth::id() == $comment->create_user )<!--もしログインしているユーザーが投稿したコメントだったら-->
                        <a class="btn btn-link" href="{{ route('remove',['id' => $comment->id,'post_id' => $post->post_id]) }}" onclick="deletePost(this); return false;">削除</a>
                    @endif　　　　　　　
                    <br />
                    <br />
                    <h5 class="sample3">{{ $comment->comment }}</h5>
                @endforeach
            @else
                コメントはありません
            @endif
            </div>
                    <br />
                    <br />
            @if (Auth::check())
            <h5><i class="fas fa-comment"></i>　コメントを投稿</h5>
            <form method="POST" action="{{ route('comment',['id' => $post->post_id]) }}">
                @csrf

                <div class="form-group">

                    <textarea
                        id="comment"
                        name="comment"
                        class="form-control {{ $errors->has('comment') ? 'is-invalid' : '' }}"
                        rows="4"
                        placeholder="コメントを入力"
                    >{{ old('comment') }}</textarea>

                    @if ($errors->has('comment'))
                        <div class="invalid-feedback">
                            {{ $errors->first('comment') }}
                        </div>
                    @endif
                </div>

                <div class="col-md-8 offset-md-8">
                    <button type="button" class="btn btn-primary" id="btn_return" onclick='location.href="{{ route('home') }}"'>トップへ</button>
                    <button type="submit" class="btn btn-primary" >コメントする</button>
                </div>
            </form>
            @else
            <h7>コメントを投稿するにはログインする必要があります</h7>
            <div class="col-md-8 offset-md-8">
                <button type="button" class="btn btn-primary" id="btn_return" onclick='location.href="{{ route('home') }}"'>トップへ</button>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

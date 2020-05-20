@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @if($posts === null)
            <div class="center">
                <br />
                <br />
                <br />
                <br />
                <h4>該当する投稿はありません</h4>
            </div>
        @else
            @foreach ($posts as $post)
                        @if($loop->iteration == 1)
                        <div class="col-md-5 col order-2">
                            <div class="center-move">
                                <i class="fas fa-crown" id="crown1"></i>1位
                            </div>
                            <div class="relative">
                                <img src="/storage/images/金縁.png" width="85%" height="50%">
                                <a class="showlink" href="{{ route('show', ['id' => $post->post_id]) }}"><img src="/storage/post_images/{{ $post->post_id }}.png" width="68%" height="84%" class="absolute1"></a>
                            </div><br />
                            <div class="center-move">
                                <a class="showlink" href="{{ route('show', ['id' => $post->post_id]) }}">{{ $post->title }}</a>
                                <i class="fas fa-thumbs-up"></i>　{{ $post->like_count }}
                            </div>


                        @elseif($loop->iteration == 2)
                        <div class="col-md-4 col order-1">
                            <div class="center-move">
                                <i class="fas fa-crown" id="crown2"></i>2位
                            </div>
                            <div class="relative">
                                <img src="/storage/images/銀縁.png" width="100%" height="100%">
                                <a class="showlink" href="{{ route('show', ['id' => $post->post_id]) }}"><img src="/storage/post_images/{{ $post->post_id }}.png" width="80%" height="72%" class="absolute2"></a>
                            </div><br />
                            <div class="center-move">
                                <a class="showlink" href="{{ route('show', ['id' => $post->post_id]) }}">{{ $post->title }}</a>
                                <i class="fas fa-thumbs-up"></i>　{{ $post->like_count }}
                            </div>
                        @elseif($loop->iteration == 3)
                        <div class="col-md-3 col order-3">
                            <div class="center-move">
                                <i class="fas fa-crown" id="crown3"></i>3位
                            </div>
                            <div class="relative">
                                <img src="/storage/images/銅縁.png" width="100%" height="100%">
                                <a class="showlink" href="{{ route('show', ['id' => $post->post_id]) }}"><img src="/storage/post_images/{{ $post->post_id }}.png" width="80%" height="72%" class="absolute3"></a>
                            </div><br />
                            <div class="center-move">
                                <a class="showlink" href="{{ route('show', ['id' => $post->post_id]) }}">{{ $post->title }}</a>
                                <i class="fas fa-thumbs-up"></i>　{{ $post->like_count }}
                            </div>

                        @endif
                        </div>
                @if($loop->iteration == 3)
                    @break
                @endif
            @endforeach
        @endif
    </div>
    <br />
    <br />
    <br />
    <br />
    <br />
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">ランキング画面
                    <form method="POST" action="{{ route('rank') }}">
                        @csrf
                        <div class="form-group row">
                            <div class="col-md-12">
                            <br />
                                @foreach($categories as $categorie)
                                <!--<input type="checkbox" name="categories[]" value="{{$categorie->categorie_id}}">-->
                                {!! Form::checkbox('categories[]', $categorie->categorie_id,null,['id' => $categorie->categorie_id]) !!}
                                {{$categorie->categorie_name}}
                                @endforeach
                                <br />
                                <div class="btn-search-center">
                                    <button type="submit" class="btn btn-primary">カテゴリ検索</button>
                                </div>
                            </div>

                            <!--checkを残す-->
                            @if($selects !== null)
                            <script>
                            @foreach($selects as $select)
                            $('input[id="{{$select}}"]').attr("checked",true);
                            @endforeach
                            </script>
                            @endif
                        </div>
                    </form>
                </div>
                @if($posts !== null)
                <div class="container mt-4">
                        @foreach ($posts as $post)
                            @if($loop->iteration > 3)
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <p class="card-text">
                                        <p>{{$loop->iteration}}位</p>
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
                                <!--上位20位まで-->
                                @if($loop->iteration == 20)
                                    @break
                                @endif
                            @endif
                        @endforeach
                </div>
                @endif
            </div>
            <div class="form-group row mb-0">
                <div class="col-md-8 offset-md-10">
                    <button type="button" class="btn btn-primary" id="btn_return" onclick='location.href="{{ route('home') }}"'>戻る</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card">
                <div class="card-header">投稿画面</div>
                    <!--カテゴリ追加成功のメッセージ-->
                    @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif

                    <!--@if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                        </ul>
                    </div>
                    @endif-->

                    <div class="card-body">
                        <form method="POST" action="{{ route('create') }}" enctype="multipart/form-data">
                            @csrf


                            <div class="form-group row">
                                <label for="comment" class="col-md-4 col-form-label text-md-right">カテゴリ(※最大5個まで)</label>


                                <div class="col-md-6">
                                    @foreach($categories as $categorie)
                                    <!--<input type="checkbox" name="categories[]" value="{{$categorie->categorie_id}}">-->
                                    {!! Form::checkbox('categories[]', $categorie->categorie_id) !!}<!--チェックボックスを保持するため-->
                                    {{$categorie->categorie_name}}
                                    @endforeach

                                    @if($errors->has('categories'))
                                    <div class="invalid-feedback2">
                                        {{ $errors->first('categories') }}<br>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6 offset-md-4">
                                カテゴリ追加は<a class="btn btn-link" href="{{ route('categorie') }}">こちら</a>
                            </div>
                            <div class="form-group row mb-0">
                            <label for="comment" class="col-md-4 col-form-label text-md-right">画像ファイル</label>
                                <div class="col-md-8 offset-md-4">
                                    <!--画像プレビュー-->
                                    <div class="preview"></div>
                                    <br />
                                    <i class="fas fa-upload"></i>
                                    <input type="file" name="photo">
                                    <!--{{Form::file('photo')}}-->

                                    <!--取得したエラーメッセージを複数表示-->
                                    @if($errors->has('photo'))
                                    @foreach($errors->get('photo') as $message)
                                    <div class="invalid-feedback2">
                                        {{ $message }}
                                    </div>
                                    @endforeach
                                    @endif

                                    <!--
                                    @if($errors->has('photo'))
                                    <div class="alert alert-danger">
                                        {{ $errors->first('photo') }}<br>
                                    </div>
                                    @endif
                                    -->
                                </div>
                            </div>
                            <br />
                            <br />
                            <br />
                            <div class="form-group row">
                                <label for="title" class="col-md-4 col-form-label text-md-right">タイトル</label>

                                <div class="col-md-6">
                                    <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" placeholder="タイトルを入力">
                                    @if($errors->has('title'))
                                    <div class="invalid-feedback2">
                                        {{ $errors->first('title') }}<br>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="comment" class="col-md-4 col-form-label text-md-right">内容</label>

                                <div class="col-md-6">
                                    <textarea id="comment" type="textarea" cols="50" rows="10" class="form-control @error('comment') is-invalid @enderror" name="comment" placeholder="内容を入力">{{ old('comment') }}</textarea>
                                    @if($errors->has('comment'))
                                    <div class="invalid-feedback2">
                                        {{ $errors->first('comment') }}<br>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="button" class="btn btn-primary" id="btn_return" onclick='location.href="{{ route('home') }}"'>戻る</button>
                                    <button type="submit" class="btn btn-primary">投稿する</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(function(){
  //画像ファイルプレビュー表示のイベント追加 fileを選択時に発火するイベントを登録
  $('form').on('change', 'input[type="file"]', function(e) {
    var file = e.target.files[0],
        reader = new FileReader(),
        $preview = $(".preview");
        t = this;

    // 画像ファイル以外の場合は何もしない
    if(file.type.indexOf("image") < 0){
      return false;
    }

    // ファイル読み込みが完了した際のイベント登録
    reader.onload = (function(file) {
      return function(e) {
        //既存のプレビューを削除
        $preview.empty();
        // .prevewの領域の中にロードした画像を表示するimageタグを追加
        $preview.append($('<img>').attr({
                  src: e.target.result,
                  width: "250px",
                  height: "250px",
                  class: "preview",
                  title: file.name
              }));
      };
    })(file);

    reader.readAsDataURL(file);
  });
});
</script>

@endsection

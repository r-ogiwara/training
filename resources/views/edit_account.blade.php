@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">　　　　　　　　　　　　　　アカウント編集画面　　　　
                    <a class="btn btn-link" href="{{ route('showChangePasswordForm') }}">パスワード変更</a>
                </div>
                <div class="card-body">
                    <form method="POST" name="add_form" action="{{ route('account.update', ['id' => Auth::id()]) }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">ご希望のアカウント名</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $user->name) }}" placeholder="アカウント名を入力" autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!--
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">メールアドレス</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        -->
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">

                                <!--<input type="checkbox" name="change" id="change" onclick="check()">-->
                                {!! Form::checkbox('change', 1 ,null,['id' => 'change','onclick' => 'check()']) !!}
                                アカウント画像を設定する<br />
                                <!--画像プレビュー-->
                                <div class="preview"></div>
                                <br />
                                <input type="file" name="photo" id="photo"><!--画像ファイルを添付-->
                                <br />
                                <br />

                                <!--取得したエラーメッセージを複数表示-->
                                @if($errors->has('photo'))
                                @foreach($errors->get('photo') as $message)
                                <div class="invalid-feedback2">
                                    {{ $message }}
                                </div>
                                @endforeach
                                @endif

                                <script>
                                //初期表示は非表示
                                document.getElementById("photo").style.visibility ="hidden";
                                </script>

                                <script>
                                check = document.add_form.change.checked;
                                if (check == true){
                                    document.getElementById("photo").style.visibility ="visible";
                                }
                                </script>

                                <script>
                                function check(){
                                    const photo = document.getElementById("photo");

                                    if(document.add_form.change.checked){
                                        // visibleで表示
                                        photo.style.visibility ="visible";
                                    }else{
                                        // hiddenで非表示
                                        photo.style.visibility ="hidden";
                                    }
                                }
                                </script>

                            </div>
                        </div>

                        <div class="form-group row">
                                <label for="introduction" class="col-md-4 col-form-label text-md-right">自己紹介</label>

                                <div class="col-md-6">
                                    <textarea id="introduction" type="textarea" cols="50" rows="10" class="form-control @error('introduction') is-invalid @enderror" name="introduction" placeholder="自己紹介を入力">{{ old('introduction', $user->introduction) }}</textarea>
                                    @if($errors->has('introduction'))
                                    <div class="invalid-feedback2">
                                        {{ $errors->first('introduction') }}<br>
                                    </div>
                                    @endif
                                </div>
                            </div>

                        <div class="form-group row">
                            <label for="lastname" class="col-md-4 col-form-label text-md-right">苗字</label>
 
                            <div class="col-md-6">
                                <input id="lastname" type="text" class="form-control @error('lastname') is-invalid @enderror" name="lastname" value="{{ old('lastname', $user->lastname) }}" placeholder="苗字を入力">
 
                                @error('lastname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="firstname" class="col-md-4 col-form-label text-md-right">名前</label>
 
                            <div class="col-md-6">
                                <input id="firstname" type="text" class="form-control @error('firstname') is-invalid @enderror" name="firstname" value="{{ old('firstname', $user->firstname) }}" placeholder="名前を入力">
 
                                @error('firstname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <br />

                        <!--郵便番号、住所入力欄を追加-->
                        <div class="form-group row">

                            <label for="postcode" class="col-md-4 col-form-label text-md-right">郵便番号</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control @error('zip21') is-invalid @enderror" name="zip21" id="zip21" size="4" maxlength="3"　value="{{ old('zip21', substr($user->postcode, 0,3)) }}" placeholder="3桁を入力"> － <input type="text" class="form-control @error('zip22') is-invalid @enderror" name="zip22" id="zip22" size="5" maxlength="4" value="{{ old('zip22', substr($user->postcode, 3)) }}" placeholder="4桁を入力" onKeyUp="AjaxZip3.zip2addr('zip21','zip22','pref21','addr21','strt21');"><br />
                                    @error('zip21')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <br />
                                <br />
                                <br />
                            <label for="address" class="col-md-4 col-form-label text-md-right">都道府県</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control @error('pref21') is-invalid @enderror" name="pref21" size="40" value="{{ old('pref21', $user->address1) }}" placeholder="都道府県を入力">
                                    @error('pref21')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                    <br />
                                </div>
                            <label for="address" class="col-md-4 col-form-label text-md-right">市区町村</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control @error('addr21') is-invalid @enderror" name="addr21" size="40" value="{{ old('addr21', $user->address2) }}" placeholder="市区町村を入力">
                                    @error('addr21')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                    <br />
                                </div>
                            <label for="address" class="col-md-4 col-form-label text-md-right">以降の住所</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control @error('strt21') is-invalid @enderror"name="strt21" size="40" value="{{ old('strt21', $user->address3) }}" placeholder="以降の住所を入力">
                                    @error('strt21')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                    <br />
                                </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="button" class="btn btn-primary" id="btn_return" onclick='location.href="{{ route('account.index', ['id' => Auth::id()]) }}"'>戻る</button>
                                <button type="submit" class="btn btn-primary" id="btn_regist">更新する</button>
                            </div>
                        </div>

                        <div class="position-right">
                            <a class="btn btn-link-danger" href="{{ route('showAccountDestroyForm') }}">アカウントを削除</a>
                        </div>

                    </form>
                </div>

                <script>
                    $(function() {
                        $('#btn_regist').on('click', function(e) {
                            e.preventDefault();//コミットをブロックしておく
                            $.ajax({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                url: '{{ route('ajax.user') }}',
                                type: 'POST',
                                data:{
                                    'name'    :  $('#name').val(),
                                }
                            })
                            // Ajaxリクエスト成功時の処理
                            .done(function(data) {
                                if(data == 0 || ("<?php echo $user->name; ?>" == $('#name').val())){ //テーブルには存在しないアカウント名か以前のアカウント名と同じであれば
                                    //window.alert("更新しました");
                                    document.add_form.submit();//コミットする
                                }
                                else{//テーブルに存在するアカウント名
                                    window.alert('すでに存在するアカウント名です');
                                }
                            })
                            // Ajaxリクエストが失敗した場合
                            .fail(function(data) {
                                window.alert("送信中止");
                            });

                        });
                    });
                </script>
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

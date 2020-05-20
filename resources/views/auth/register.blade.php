@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">アカウント登録画面</div>

                <div class="card-body">
                    <form method="POST" name="add_form" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">ご希望のアカウント名</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="アカウント名を入力" autocomplete="name" autofocus>

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

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">パスワード</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="パスワードを入力" autocomplete="password">
                                <!--{!! Form::password('password',['class' => "form-control",'placeholder' => "パスワードを入力"]) !!}-->
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">パスワード（確認のため再度入力してください）</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="パスワードを入力(再)" autocomplete="new-password">
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="lastname" class="col-md-4 col-form-label text-md-right">苗字</label>
 
                            <div class="col-md-6">
                                <input id="lastname" type="text" class="form-control @error('lastname') is-invalid @enderror" name="lastname" value="{{ old('lastname') }}" placeholder="苗字を入力">
 
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
                                <input id="firstname" type="text" class="form-control @error('firstname') is-invalid @enderror" name="firstname" value="{{ old('firstname') }}" placeholder="名前を入力">
 
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
                                    <input type="text" class="form-control @error('zip21') is-invalid @enderror" name="zip21" id="zip21" size="4" maxlength="3"　value="{{ old('zip21') }}" placeholder="3桁を入力"> － <input type="text" class="form-control @error('zip22') is-invalid @enderror" name="zip22" id="zip22" size="5" maxlength="4" value="{{ old('zip22') }}" placeholder="4桁を入力" onKeyUp="AjaxZip3.zip2addr('zip21','zip22','pref21','addr21','strt21');"><br />
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
                                    <input type="text" class="form-control @error('pref21') is-invalid @enderror" name="pref21" size="40" value="{{ old('pref21') }}" placeholder="都道府県を入力">
                                    @error('pref21')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                    <br />
                                </div>
                            <label for="address" class="col-md-4 col-form-label text-md-right">市区町村</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control @error('addr21') is-invalid @enderror" name="addr21" size="40" value="{{ old('addr21') }}" placeholder="市区町村を入力">
                                    @error('addr21')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                    <br />
                                </div>
                            <label for="address" class="col-md-4 col-form-label text-md-right">以降の住所</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control @error('strt21') is-invalid @enderror"name="strt21" size="40" value="{{ old('strt21') }}" placeholder="以降の住所を入力">
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
                                <button type="button" class="btn btn-primary" id="btn_return" onclick='location.href="{{ route('home') }}"'>戻る</button>
                                <button type="submit" class="btn btn-primary" id="btn_regist">登録する</button>
                            </div>
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
                                    'name'    :  $('#name').val(),//カテゴリ名
                                }
                            })
                            // Ajaxリクエスト成功時の処理
                            .done(function(data) {
                                if(data == 0){
                                    //window.alert("更新しました");
                                    document.add_form.submit();//コミットする
                                }
                                else{
                                    window.alert('すでに存在するIDです');
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
@endsection

@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">退会処理画面</div>

        @if (session('change_password_error'))
          <div class="container mt-2">
            <div class="alert alert-danger">
              {{session('change_password_error')}}
            </div>
          </div>
        @endif

        @if (session('change_password_success'))
          <div class="container mt-2">
            <div class="alert alert-success">
              {{session('change_password_success')}}
            </div>
          </div>
        @endif

        <div class="card-body">
          <form method="POST" name="delete_account_form" action="{{ route('accountdestroy') }}">
            @csrf

            <h4>退会する</h4>
            </br>
            <p>※退会処理を行うと、これまで投稿した内容など全て削除されます。</p>
            <div class="form-group row">
                <label for="password" class="col-md-4 col-form-label text-md-right">パスワード</label>

              <div class="col-md-6">
                <input id="current" type="password" class="form-control @error('current-password') is-invalid @enderror" name="current-password" placeholder="パスワードを入力" autocomplete="password" autofocus>
                    <!--{!! Form::password('password',['class' => "form-control",'placeholder' => "パスワードを入力"]) !!}-->
                    @error('current-password')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                    @enderror
              </div>
            </div>

            <div class="form-group row mb-0">
              <div class="col-md-6 offset-md-4">
                  <a class="btn btn-link" href="{{ route('account.edit', ['id' => Auth::id()]) }}">キャンセル</a>
                  <button type="submit" class="btn btn-danger" onclick="deletePost(this); return false;">退会する</button>
              </div>
            </div>

            <script>
                  function deletePost(e){
                      "use strict";
                      if(window.confirm('本当に退会しますか？')){
                          document.getElementById('delete_' + e.dataset.id).submit();
                      }else{
                          window.alert('キャンセルされました');
                          return false;
                      }
                  }
              </script>

          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

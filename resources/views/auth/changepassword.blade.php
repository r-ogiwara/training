@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">パスワード変更画面</div>

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
          <form method="POST" action="{{route('changepassword')}}">
            @csrf

            <div class="form-group row">
                <label for="password" class="col-md-4 col-form-label text-md-right">現在のパスワード</label>

                <div class="col-md-6">
                <input id="current" type="password" class="form-control @error('current-password') is-invalid @enderror" name="current-password" placeholder="現在のパスワードを入力" autocomplete="password" autofocus>
                    <!--{!! Form::password('password',['class' => "form-control",'placeholder' => "パスワードを入力"]) !!}-->
                    @error('current-password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="current" class="col-md-4 col-form-label text-md-right">新しいパスワード</label>

                <div class="col-md-6">
                <input id="password" type="password" class="form-control @error('new-password') is-invalid @enderror" name="new-password" placeholder="新しいパスワードを入力" autocomplete="password" >
                    <!--{!! Form::password('password',['class' => "form-control",'placeholder' => "パスワードを入力"]) !!}-->
                    @error('new-password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="current" class="col-md-4 col-form-label text-md-right">現在のパスワード(確認用）</label>

                <div class="col-md-6">
                <input id="confirm" type="password" class="form-control @error('new-password_confirmation') is-invalid @enderror" name="new-password_confirmation" placeholder="新しいパスワードを再入力" autocomplete="password" >
                    <!--{!! Form::password('password',['class' => "form-control",'placeholder' => "パスワードを入力"]) !!}-->
                    @error('new-password_confirmation')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                    <a class="btn btn-link" href="{{ route('account.edit', ['id' => Auth::id()]) }}">キャンセル</a>
                    <button type="submit" class="btn btn-primary" id="btn_regist">変更する</button>
                </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

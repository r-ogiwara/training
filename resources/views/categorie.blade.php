@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">カテゴリ追加画面</div>

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
                        <form method="POST" name="add_form" action="{{ route('categorieAdd') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group row">
                                <label for="title" class="col-md-4 col-form-label text-md-right">カテゴリ名</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="カテゴリ名を入力" required autocomplete="name" autofocus>

                                    @if($errors->has('name'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('name') }}<br>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="title" class="col-md-4 col-form-label text-md-right">ふりがな(ひらがなのみ）※任意</label>

                                <div class="col-md-6">
                                    <input id="furigana" type="text" name="furigana" class="form-control{{ $errors->has('furigana') ? ' is-invalid' : '' }}" value="{{ old('furigana') }}" placeholder="ふりがなを入力">

                                    @if($errors->has('furigana'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('furigana') }}<br>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="button" class="btn btn-primary" id="btn_return" onclick='location.href="{{ route('post') }}"'>戻る</button>
                                    <button type="submit" class="btn btn-primary" id="ajax">追加する</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <script>
                    $(function() {
                        $('#ajax').on('click', function(e) {
                            e.preventDefault();//コミットをブロックしておく
                            $.ajax({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                url: '{{ route('ajax.categorie') }}',
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
                                    window.alert('すでに存在するカテゴリです');
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
</div>
@endsection

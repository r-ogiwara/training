<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', function () {
    return view('welcome');
});*/
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');//トップページを開く
Route::post('/home', 'HomeController@index')->name('home');//検索の場合
Route::get('/post', 'PostController@post')->name('post');//投稿ページを開く
Route::post('/post', 'PostController@create')->name('create');//投稿処理
Route::get('/categorie', 'HomeController@categorie')->name('categorie');//カテゴリ追加ページを開く
Route::post('/categorieAdd', 'HomeController@categorieAdd')->name('categorieAdd');//カテゴリ追加処理
Route::post('/ajax/categorie','AjaxController@ajaxCategorieCheck')->name('ajax.categorie');//ajaxカテゴリチェックバリデーション
Route::post('/ajax/user','AjaxController@ajaxUserCheck')->name('ajax.user');//ajaxユーザチェックバリデーション
Route::get('/show/{id}','HomeController@show')->name('show');//詳細ページへ
Route::get('/edit/{id}','PostController@edit')->name('edit');//編集ページへ
Route::post('/update/{id}','PostController@update')->name('update');//更新処理
Route::get('/destroy/{id}','PostController@destroy')->name('destroy');//投稿削除処理
Route::post('/comment/{id}','HomeController@comment')->name('comment');//コメント投稿処理
Route::get('/remove/{id}/{post_id}','HomeController@remove')->name('remove');//コメント削除処理
Route::get('/ajax/like/{id}','AjaxController@ajaxLikeCheck')->name('ajax.like');//ajaxユーザチェックバリデーション
Route::get('/rank', 'HomeController@rank')->name('rank');//トップページを開く
Route::post('/rank', 'HomeController@rank')->name('rank');//カテゴリ検索の場合
Route::get('/account/index/{id}','AccountController@index')->name('account.index');//詳細ページへ
Route::get('/account/edit/{id}','AccountController@edit')->name('account.edit');//編集ページへ
Route::get('/account/good/{id}', 'AccountController@good')->name('account.good');//goodした投稿一覧ページを開く
Route::get('deleteaccount','AccountController@showDestroyForm')->name('showAccountDestroyForm');//退会処理ページへ
Route::post('deleteaccount','AccountController@destroy')->name('accountdestroy');//退会処理
Route::post('/account/update/{id}','AccountController@update')->name('account.update');//更新ページへ
Route::get('changepassword', 'AccountController@showChangePasswordForm')->name('showChangePasswordForm');//パスワード変更ページへ
Route::post('changepassword', 'AccountController@changePassword')->name('changepassword');//パスワード変更処理
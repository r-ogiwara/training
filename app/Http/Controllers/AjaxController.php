<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Like;
use Illuminate\Support\Facades\DB;//DBにアクセス
use Illuminate\Support\Facades\Log;//ログ確認
use Illuminate\Support\Facades\Auth;//ユーザー情報取得するため

class AjaxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ajaxCategorieCheck(Request $request){//アラートメッセージを返すメソッド
        //dd($request->name);
        $data = 0;
        $categorie = DB::table('categorie_masters');
        $categorie = $categorie->select('categorie_id');
        $categorie = $categorie->where('categorie_name','=',"$request->name");
        $categorie = $categorie->get();

        if(count($categorie) > 0){
            $data = 1;
        }
        echo $data;
    }

    public function ajaxUserCheck(Request $request){//アラートメッセージを返すメソッド
        //dd($request->name);
        $data = 0;

        $user = DB::table('users');
        $user = $user->select('id');
        $user = $user->where('name','=',"$request->name");
        $user = $user->get();

        if(count($user) > 0){
            $data = 1;
        }
        echo $data;
    }

    public function ajaxLikeCheck($id){
        $data = -1;
        if (Auth::check()) {//ユーザがログインしているか
            $user_id = Auth::id();
            $like_count = DB::table('likes')//Likes表参照
            ->select('id')
            ->where('user_id', '=', $user_id)
            ->where('post_id', '=', $id)
            ->count();

            //すでにイイねしているか
            if ($like_count > 0) {
                //イイねを消す処理
                $like = Like::where('user_id', '=', $user_id)
                ->where('post_id', '=', $id)
                ->delete();
            } else {
                //イイねを追加する処理
                $like = new Like;
                $like->user_id = $user_id;
                $like->post_id = $id;
                $like->save();
            }

            $data = DB::table('likes')//Likes表参照
            ->select('id')
            ->where('post_id', '=', $id)
            ->count();
        }
        echo $data;//この投稿が持つイイね数を返す
    }
}
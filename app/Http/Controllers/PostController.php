<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\PostArt;//modelを利用
use App\ArtCategorie;
use App\CategorieMaster;
use App\Comment;
use App\Like;
use Illuminate\Support\Facades\DB;//DBにアクセス
use Illuminate\Support\Facades\Log;//ログ確認
use Illuminate\Support\Facades\Auth;//ユーザー情報取得するため
use App\Http\Requests\UpdateArtRequest;
use App\Http\Requests\PostRequest;
use Carbon\Carbon;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function post()//投稿画面表示
    {
        //カテゴリ一覧を取得
       $categories = DB::table('categorie_masters')
       ->select('*')
       ->orderByRaw('furigana is null asc')
       ->orderBy('furigana','asc')
       ->orderBy('categorie_id','asc')
       ->get();
       //dd($categories);
        return view('post',compact('categories'));
    }

    public function index(Request $request)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(PostRequest $request)//投稿内容をDBに保存
    {
        //投稿表に入力されたデータを登録
        $postArt = new PostArt;

        $postArt->title = $request->input('title');
        $postArt->comment = $request->input('comment');
        $postArt->user_id = Auth::id();
        //dd($postArt);
        $postArt->save();
        //今投稿した投稿のidを取り出す
        $id = $postArt->post_id;
        //dd($request->categories);
        //作品カテゴリ表に入力されたカテゴリを登録
        foreach($request->categories as $value){
                $artCategorie = new ArtCategorie;
                $artCategorie->art_id = $id;
                $artCategorie->categorie_id = $value;
                $artCategorie->save();
        }

        //画像の名前に取り出したidを指定する
        $request->photo->storeAs('public/post_images', "$id". '.png');
        //再度投稿画面へ
        return redirect('home')->with('success', '新しい作品を投稿しました');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //

    }

    public function edit($id)
    {
        //
        $categories = DB::table('categorie_masters')
            ->select('*')
            ->orderByRaw('furigana is null asc')
            ->orderBy('furigana','asc')
            ->orderBy('categorie_id','asc')
            ->get();
       //dd($categories);

       $post = PostArt::select('post_arts.*')
            ->where('post_id',"$id")
            ->first();
       //dd($post);

       $selects = ArtCategorie::select('categorie_id')
            ->where('art_id',"$id")
            ->get();

        return view('edit',compact('categories','selects','post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateArtRequest $request, $id)
    {
        //編集画面に入力されたデータで更新
        $post = PostArt::find($id);
        $post->title = $request->title;
        $post->comment = $request->comment;
        $post->updated_at = new Carbon(Carbon::now());
        $post->save();

        ArtCategorie::where('art_id', $id)->delete();


        //作品カテゴリ表に入力されたカテゴリを登録
        foreach($request->categories as $value){
                $artCategorie = new ArtCategorie;
                $artCategorie->art_id = $id;
                $artCategorie->categorie_id = $value;
                $artCategorie->save();
        }

        //画像の名前に編集する投稿のidを指定する
        if (isset($request->change)) {
            $request->photo->storeAs('public/post_images', "$id". '.png');
        }
        //再度詳細画面へ
        return redirect('show'.'/'.$id)->with('success', '作品を更新しました');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //選択された行のデータ削除
        PostArt::find($id)->delete();
        ArtCategorie::where('art_id','=',$id)->delete();
        Comment::where('art_id','=',$id)->delete();
        Like::where('post_id','=',$id)->delete();
        $pathdel = storage_path() . '/app/public/post_images/' . "$id" . '.png';
        \File::delete($pathdel);//storageに保存された画像の削除
        return redirect('home')->with('success', '投稿を削除しました');
    }

    public function top()
    {
        //
    }
}

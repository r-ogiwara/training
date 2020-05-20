<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CategorieMaster;//modelを利用
use App\PostArt;
use App\Comment;
use App\Like;
use App\ArtCategorie;
use Illuminate\Support\Facades\DB;//DBにアクセス
use Illuminate\Support\Facades\Log;//ログ確認
use Illuminate\Support\Facades\Auth;//ユーザー情報取得するため
use App\Http\Requests\furiganaRequest;
use App\Http\Requests\CommentRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    /*public function __construct()
    {
        $this->middleware('auth');
    }*/

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)//投稿一覧を表示
    {
        //dd($request->search);
        if(isset($request->search)){
            $posts = PostArt::select('post_arts.*','name',DB::raw( '(SELECT COUNT(*) FROM likes WHERE likes.post_id = post_arts.post_id) AS like_count' ))
            ->join('users','id','=','post_arts.user_id')
            ->where('title','LIKE', "%$request->search%")
            ->orWhere('comment','LIKE', "%$request->search%")
            ->orderBy('created_at', 'desc')->paginate(5);
        }
        else{
            $posts = PostArt::select('post_arts.*','name',DB::raw( '(SELECT COUNT(*) FROM likes WHERE likes.post_id = post_arts.post_id) AS like_count' ))
            ->join('users', 'id', '=', 'post_arts.user_id')
            ->orderBy('created_at', 'desc')->paginate(5);
        }

        return view('home', ['posts' => $posts]);
    }

    public function categorie()
    {
        return view('categorie');
    }

    public function categorieAdd(furiganaRequest $request)
    {
        $categorieMaster = new CategorieMaster;

        $categorieMaster->categorie_name = $request->input('name');
        $categorieMaster->furigana = $request->input('furigana');
        $categorieMaster->create_user = Auth::id();
        $categorieMaster->update_user = Auth::id();
        $categorieMaster->save();
        return redirect('post')->with('success', '新しいカテゴリを追加しました');
    }

    public function show($id)
    {

        $like_count = Like::select('id')
            ->where('post_id', '=', $id)
            ->count();

        $post = PostArt::select('post_arts.*','name')
            ->join('users', 'id', 'post_arts.user_id')
            ->where('post_id',"$id")
            ->first();

        $user_like = 0;
        if (Auth::check()) {//ユーザがすでにイイねしているか
            $user_id = Auth::id();
            $user_like = Like::select('id')
                ->where('user_id', '=', $user_id)
                ->where('post_id', '=', $id)
                ->count();
        }

        $selects = CategorieMaster::select('categorie_name')
            ->join('art_categories','art_categories.categorie_id', '=', 'categorie_masters.categorie_id')
            ->where('art_id',"$id")
            ->get();

        $comments = Comment::select('comments.id','comment','create_user','comments.created_at','name')//コメント一覧を表示できるよう編集
            ->join('users', 'users.id', '=', 'comments.create_user')
            ->where('art_id',"$id")
            ->orderBy('comments.created_at', 'desc')
            ->get();

        $cnt = $comments->count();

        return view('show',compact('post','selects','comments','cnt','like_count','user_like'));
    }

    public function comment(CommentRequest $request,$id)//投稿一覧を表示
    {
        //投稿表に入力されたデータを登録
        $comment = new Comment;

        $comment->art_id = $id;
        $comment->comment = $request->input('comment');
        $comment->create_user = Auth::id();
        $comment->save();

        return redirect('show'.'/'.$id)->with('success', 'コメントを投稿しました');
    }

    public function remove($id,$post_id)
    {
        //選択された行のデータ削除
        Comment::find($id)->delete();
        return redirect('show'.'/'.$post_id)->with('success', 'コメントを削除しました');
    }

    public function rank(Request $request)//投稿一覧を表示
    {
        if (isset($request->categories)) {
            //検索後のランキング

            //1.art_categories表からチェックボックスで選択されたカテゴリを含みlikes表に存在する投稿idを取りだす
            $post_ids = DB::table('art_categories')
                ->select('art_id')
                ->join('likes', 'art_categories.art_id', '=', 'likes.post_id');
            foreach ($request->categories as $value) {
                $post_ids = $post_ids->orWhere('categorie_id', $value);
            }
            $post_ids = $post_ids->groupBy('art_id')->get();

            $selects = $request->categories;

            if ($post_ids->isEmpty()) {//コレクション型が空だった場合
                $posts = null;
            }else{
                //2.post_arts表とusers表から取り出した投稿idの投稿データ全てとユーザ名をイイね数順で取り出す
                $posts = PostArt::select('post_arts.*', 'name', DB::raw('(SELECT COUNT(*) FROM likes WHERE likes.post_id = post_arts.post_id) AS like_count'))
                    ->join('users', 'id', '=', 'post_arts.user_id');
                foreach ($post_ids as $post_id) {
                    $posts = $posts->orWhere('post_id', '=', $post_id->art_id);
                }
                $posts = $posts->orderBy('like_count', 'desc')->orderBy('created_at', 'desc')->get();
            }
            //Log::debug('デバッグ１');
            //Log::debug($posts);
            //dd($post_ids);
        }
        else{
            $selects = null;

            $posts = PostArt::select('post_arts.*', 'name', DB::raw( '(SELECT COUNT(*) FROM likes WHERE likes.post_id = post_arts.post_id) AS like_count' ))
                ->join('users', 'id', '=', 'post_arts.user_id')
                ->orderBy('like_count','desc')
                ->orderBy('created_at','desc')
                ->get();
        }

        $categories = DB::table('categorie_masters')
            ->select('*')
            ->orderByRaw('furigana is null asc')
            ->orderBy('furigana','asc')
            ->orderBy('categorie_id','asc')
            ->get();

        //dd($posts);

        return view('rank',compact('posts','categories','selects'));
    }
}

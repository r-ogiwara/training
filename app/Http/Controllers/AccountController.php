<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\PostArt;//modelを利用
use App\ArtCategorie;
use App\CategorieMaster;
use App\Comment;
use App\Like;
use App\User;
use Illuminate\Support\Facades\DB;//DBにアクセス
use Illuminate\Support\Facades\Log;//ログ確認
use Illuminate\Support\Facades\Auth;//ユーザー情報取得するため
use Carbon\Carbon;
use App\Http\Requests\AccountRequest;
use App\Http\Requests\PasswordRequest;
use App\Http\Requests\DeleteAccountRequest;
use Hash;
use Illuminate\Support\Facades\Storage;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)//アカウント画面(このユーザーの投稿一覧画面）の表示
    {
        //ユーザ名取得
        $user = User::select('id','name','introduction')
            ->where('id', $id)
            ->first();

        //投稿一覧取得
        $posts = PostArt::select('post_arts.*','name',DB::raw( '(SELECT COUNT(*) FROM likes WHERE likes.post_id = post_arts.post_id) AS like_count' ))
            ->join('users','id','=','post_arts.user_id')
            ->where('post_arts.user_id', $id)
            ->orderBy('created_at', 'desc')->paginate(5);

        //投稿数取得
        $post_count = DB::table('post_arts')
            ->where('user_id', $id)
            ->count();

        //投稿した投稿idを取得
        $post_ids = PostArt::select('post_id')
            ->where('post_arts.user_id', $id)
            ->get();

        //総イイね数取得
        if ($post_ids->isEmpty()) {//コレクション型が空だった場合
            $total_like = 0;
        }else{
            $total_like = DB::table('likes');
            foreach ($post_ids as $post_id) {
                $total_like = $total_like->orWhere('post_id', $post_id->post_id);
            }
            $total_like = $total_like->count();
        }

        /*アカウント画像が存在するかチェック
        $filepath = Storage::exists('public/account_images/'."$id".'.png');*/

        return view('account',compact('user','posts','post_count','total_like'));
    }

    public function good($id)//アカウント画面(このユーザーの投稿一覧画面）の表示
    {
        //ユーザ名取得
        $user = User::select('id','name','introduction')
            ->where('id', $id)
            ->first();

        //投稿一覧取得
        $posts = PostArt::select('post_arts.*','name',DB::raw( '(SELECT COUNT(*) FROM likes WHERE likes.post_id = post_arts.post_id) AS like_count' ))
            ->join('users','id','=','post_arts.user_id')
            ->join('likes','likes.post_id','=','post_arts.post_id')
            ->where('likes.user_id', $id)
            ->orderBy('created_at', 'desc')->paginate(5);

        //投稿数取得
        $post_count = DB::table('post_arts')
            ->where('user_id', $id)
            ->count();

        //投稿した投稿idを取得
        $post_ids = PostArt::select('post_id')
            ->where('post_arts.user_id', $id)
            ->get();

        //総イイね数取得
        if ($post_ids->isEmpty()) {//コレクション型が空だった場合
            $total_like = 0;
        }else{
            $total_like = DB::table('likes');
            foreach ($post_ids as $post_id) {
                $total_like = $total_like->orWhere('post_id', $post_id->post_id);
            }
            $total_like = $total_like->count();
        }

        /*アカウント画像が存在するかチェック
        $filepath = Storage::exists('public/account_images/'."$id".'.png');*/

        return view('good',compact('user','posts','post_count','total_like'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)//アカウント編集画面へ
    {
        //
        $user = DB::table('users')
            ->select('*')
            ->where('id',$id)
            ->first();

        return view('edit_account',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AccountRequest $request, $id)
    {
        //
        //編集画面に入力されたデータで更新
        $user = User::find($id);
        $user->name = $request->name;
        $user->introduction = $request->introduction;
        $user->lastname = $request->lastname;
        $user->firstname = $request->firstname;
        $user->postcode = $request->zip21.$request->zip22;
        $user->address1 = $request->pref21;
        $user->address2 = $request->addr21;
        $user->address3 = $request->strt21;
        $user->updated_at = new Carbon(Carbon::now());
        $user->save();

        //画像の名前にユーザーidを指定する
        if (isset($request->change)) {
            $request->photo->storeAs('public/account_images', "$id". '.png');
        }

        return redirect('account'.'/'.'index'.'/'.$id)->with('success', 'アカウント情報を更新しました');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function showDestroyForm()
    {
        //
        return view('auth.delete_account');
    }

    public function destroy(DeleteAccountRequest $request)
    {
        //現在のパスワードが正しいかを調べる
        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            return redirect()->back()->with('change_password_error', 'パスワードが間違っています。');
        }
        $user = Auth::user();
        $id = Auth::id();
        // ログアウト、update処理が行われる。
        Auth::logout();

        //comments表からこのユーザのコメントを削除
        Comment::where('create_user',$id)->delete();

        //Comments表からこのユーザが投稿した投稿へのコメントを削除
        $comments = Comment::join('post_arts','comments.art_id','=','post_arts.post_id');
        $comments->where('post_arts.user_id',$id);
        $comments->delete();

        //Likes表からこのユーザのイイねを削除
        Like::where('user_id',$id)->delete();

        //Likes表からこのユーザが投稿した投稿へのイイねを削除
        $likes = Like::join('post_arts','likes.post_id','=','post_arts.post_id');
        $likes->where('post_arts.user_id',$id);
        $likes->delete();

        //art_categories表からこのユーザが投稿した投稿のカテゴリを削除
        $art_categories = ArtCategorie::join('post_arts','art_categories.art_id','=','post_arts.post_id');
        $art_categories->where('post_arts.user_id',$id);
        $art_categories->delete();

        //post_arts表からこのユーザが投稿した投稿idを取得する
        $post_ids = PostArt::query();
        $post_ids->where('user_id',$id);
        $post_ids = $post_ids->get();

        //post_arts表からこのユーザの投稿を削除
        PostArt::where('user_id',$id)->delete();

        //投稿した画像を削除
        foreach($post_ids as $post_id){
            $pathdel[] = storage_path() . '/app/public/post_images/' . "$post_id" . '.png';
        }
        /*
        for ($i = 0;$i < count($pathdel); $i++){
            \File::delete($pathdel[$i]);//storageに保存された画像の削除
        }
        */
        //user表からこのユーザを削除
        $user->delete();


        return redirect('home')->with('success', 'アカウントを削除しました。ご利用ありがとうございました。');
    }

    public function showChangePasswordForm() {
        return view('auth.changepassword');
    }

    public function changePassword(PasswordRequest $request) {
        //現在のパスワードが正しいかを調べる
        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            return redirect()->back()->with('change_password_error', '現在のパスワードが間違っています。');
        }

        //現在のパスワードと新しいパスワードが違っているかを調べる
        if (strcmp($request->get('current-password'), $request->get('new-password')) == 0) {
            return redirect()->back()->with('change_password_error', '新しいパスワードが現在のパスワードと同じです。違うパスワードを設定してください。');
        }

        //パスワードを変更
        $user = Auth::user();
        $user->password = bcrypt($request->get('new-password'));
        $user->save();

        return redirect()->back()->with('change_password_success', 'パスワードを変更しました。');
    }
}

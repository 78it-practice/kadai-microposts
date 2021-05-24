<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Micropost;

class MicropostsController extends Controller
{
    //Micropost一覧の表示
    public function index()
    {
        $data = [];

        //認証済みの場合
        if(\Auth::check()) {
            //認証済みユーザを取得
            $user = \Auth::user();
            //ユーザの投稿の一覧を作成日時の降順で取得
            $microposts = $user->feed_microposts()->orderBy('created_at', 'desc')->paginate(10);
            
            $data = [
                'user' => $user,
                'microposts' => $microposts
            ];
        }
        
        return view('welcome', $data);
    }
    
    //Micropostの投稿
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|max:255'
        ]);
        
        //認証済みユーザの投稿として作成
        $request->user()->microposts()->create([
            'content' => $request->content
        ]);
        
        //前のURLへリダイレクト
        return back();
    }
    
    //Micropostの削除
    public function destroy($id)
    {
        $micropost = Micropost::findOrFail($id);
        
        //認証済みユーザと対象のMicropostの投稿者が一緒なら削除
        if(\Auth::id() === $micropost->user_id) {
            $micropost->delete();
        }
        
        return back();
    }
}

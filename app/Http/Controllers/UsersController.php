<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::orderBy('id', 'desc')->paginate(10);
        
        return view('users.index', [
            'users' => $users
        ]);
    }
    
    public function show($id)
    {
        $user = User::findOrFail($id);
        $user->loadRelationshipCounts();
        $microposts = $user->microposts()->orderBy('created_at', 'desc')->paginate(10);
        
        return view('users.show', [
            'user' => $user,
            'microposts' => $microposts
        ]);
    }
    
    //ユーザのフォロー一覧ページを表示
    public function followings($id)
    {
        $user = User::findOrFail($id);
        $user->loadRelationshipCounts();                    //関連モデル件数
        $followings = $user->followings()->paginate(10);    //フォロー一覧
        
        return view('users.followings', [
            'user' => $user,
            'users' => $followings
        ]);
    }
    
    //ユーザのフォロワー一覧ページを表示
    public function followers($id)
    {
        $user = User::findOrFail($id);
        $user->loadRelationshipCounts();
        $followers = $user->followers()->paginate(10);
        
        return view('users.followers', [
            'user' => $user,
            'users' => $followers
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FavoritesController extends Controller
{
    //投稿をお気に入り登録する
    public function store($id)
    {
        \Auth::user()->favorite($id);
        
        return back();
    }
    
    //投稿のお気に入りを解除する
    public function destroy($id) {
        \Auth::user()->unfavorite($id);
        
        return back();
    }
}

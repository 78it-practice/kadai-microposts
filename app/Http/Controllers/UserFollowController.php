<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserFollowController extends Controller
{
    /**
     * ユーザをフォローするアクション
     * 
     * @param $id フォロー対象ユーザのid
     * @return \Illuminate\Http\Response
     */
    public function store($id)
    {
        \Auth::user()->follow($id);
        
        return back();
    }
    
    /**
     * ユーザのフォローを解除するアクション
     * 
     * @param $id フォロー解除対象ユーザのid
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        \Auth::user()->unfollow($id);
        
        return back();
    }
}

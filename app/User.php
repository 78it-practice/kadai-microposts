<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //ユーザに関係するModelの件数を読む
    public function loadRelationshipCounts()
    {
        $this->loadCount(['microposts', 'followings', 'followers']);
    }
    
    //このユーザが所持する投稿（Micropostとの関係を定義）多なので複数形でmicroposts
    public function microposts()
    {
        return $this->hasMany(Micropost::class);
    }
    
    //このユーザがフォロー中のユーザ 多対多なのでこれも下のやつも複数形
    public function followings()
    {
        return $this->belongsToMany(User::class, 'user_follow', 'user_id', 'follow_id')->withTimestamps();
    }
    
    //このユーザをフォローしているユーザ
    public function followers()
    {
        return $this->belongsToMany(User::class, 'user_follow', 'follow_id', 'user_id')->withTimestamps();
    }
    
    /**
     * $userIdで指定されたユーザをフォローする
     * 
     * @param int $userId
     * @return bool
     */
    public function follow($userId)
    {
        //すでにフォローしているか
        $exist = $this->is_following($userId);
        //対象が自分自身かどうか
        $its_me = $this->id == $userId;
        
        if($exist || $its_me) {
            //何もしない
            return false;
        }
        else {
            $this->followings()->attach($userId);
            return true;
        }
    }
    
    /**
     * $userIdで指定されたユーザのフォローを外す
     * 
     * @param int $userId
     * @return bool
     */
    public function unfollow($userId)
    {
        $exist = $this->is_following($userId);
        $its_me = $this->id == $userId;
        
        if($exist && !$its_me) {
            $this->followings()->detach($userId);
            return true;
        }
        else {
            return false;
        }
    }
    
    /**
     * 指定された$userIdのユーザをフォロー中か調べる
     * 
     * @param int $userId
     * @return bool
     */
    public function is_following($userId)
    {
        return $this->followings()->where('follow_id', $userId)->exists();
    }
}

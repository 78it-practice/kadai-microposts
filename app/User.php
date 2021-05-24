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
        $this->loadCount(['microposts', 'followings', 'followers', 'favorites']);
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
    
    //ユーザがお気に入り登録している投稿
    public function favorites()
    {
        return $this->belongsToMany(Micropost::class, 'favorites', 'user_id', 'micropost_id');
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
    
    //このユーザとフォロー中ユーザの投稿に絞る
    public function feed_microposts()
    {
        //フォロー中のユーザのidを取得し配列にする
        $userIds = $this->followings()->pluck('users.id')->toArray();
        //このユーザのidもそれに追加
        $userIds[] = $this->id;
        
        return Micropost::whereIn('user_id', $userIds);
    }
    
    //投稿をお気に入りに登録する
    public function favorite($micropostId)
    {
        $exist = $this->is_favorited($micropostId);
        
        if(!$exist) {
            $this->favorites()->attach($micropostId);
            return true;
        }
        else {
            return false;
        }
    }
    
    //お気に入り登録を解除する
    public function unfavorite($micropostId)
    {
        $exist = $this->is_favorited($micropostId);
        
        if($exist) {
            $this->favorites()->detach($micropostId);
            return true;
        }
        else {
            return false;
        }
    }
    
    //お気に入り登録されているかどうか調べる
    public function is_favorited($micropostId)
    {
        return $this->favorites()->where('micropost_id', $micropostId)->exists();
    }
}

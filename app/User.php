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
        $this->loadCount('microposts');
    }
    
    //このユーザが所持する投稿（Micropostとの関係を定義）多なので複数形でmicroposts
    public function microposts()
    {
        return $this->hasMany(Micropost::class);
    }
}

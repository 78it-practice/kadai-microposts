<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Micropost extends Model
{
    protected $fillable = ['content'];
    
    //投稿したユーザ（Userモデルとの関係を定義）1なので単数形でuser
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

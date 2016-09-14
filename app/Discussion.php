<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Discussion extends Model
{
    protected $fillable = [
        'title', 'body', 'user_id', 'last_user_id'
    ];

    // 通过 $discussion->user 就拿到user数据
    public function user(){
        //默认指定外键就是user_id字段，如果是其它字段就在后面添加 (User::class,'user_id')
        return $this->belongsTo(User::class);

    }

    // 通过 $discussion->comments 就拿到comments数据 一对多关系
    public function comments(){

        return $this->hasMany(Comment::class);
    }

}

<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar','confirm_code'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    // discussions表中的user_id字段是 users表中的外键
    //通过user表中的用户，就可以拿到discussions表中的关联数据（关系是一对多）
    public function discussions(){
        // user表中的用户发布帖子就可以拿到，通过$user->discussions()
        return $this->hasMany(Discussion::class);

    }
    //拿到用户评论数据
    public function comments(){
        // 一对多关系
        return $this->hasMany(Comment::class);
    }



    //将user表中的password字段进行加密
    public function setPasswordAttribute($password){

        $this->attributes['password'] = \Hash::make($password);

    }









}

<?php

namespace App;

use App\BaseModel;

class Post extends BaseModel
{
    //关联用户
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    //评论模型（文章和评论是一对多的关系）
    public function comments()
    {
        return $this->hasMany('App\Comment')->orderBy('created_at', 'desc');
    }

    //和用户进行关联，一个用户只能给一篇文章点一个赞
    public function zan($user_id)
    {
        //一个文章和一个用户只能产生一个赞关联
        return $this->hasOne(\App\Zan::class)->where('user_id', $user_id);
    }

    //文章的所有赞
    public function zans()
    {
        //一篇文章有多个赞
        $this->hasMany(\App\Zan::class);
    }
}

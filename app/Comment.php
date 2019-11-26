<?php

namespace App;

use App\BaseModel;

class Comment extends BaseModel
{
    //评论所属文章(一对多的反向)
    public function post()
    {
        return $this->belongsTo('App\Post');
    }

    //评论所属用户
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}

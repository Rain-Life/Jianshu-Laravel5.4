<?php

namespace App;

use App\BaseModel;

class Topic extends BaseModel
{
    //获取专题下的文章
    public function posts()
    {
        $this->belongsToMany(\App\Post::class, 'post_topics', 'topic_id', 'post_id');
    }

    //专题的文章数  用于withCount
    public function postTopics()
    {
        $this->hasMany(\App\PostTopic::class, 'topic_id');
    }
}

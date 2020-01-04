<?php

namespace App;

use App\BaseModel;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Scout\Searchable;

class Post extends BaseModel
{
    use Searchable;

    //定义索引里边的type
    public function searchableAs()
    {
        return "post";
    }
    //定义哪些字段需要搜索
    public function toSearchableArray()
    {
        return [
            'title' => $this->title,
            'content' => $this->content,
        ];
    }

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
        $this->hasMany(\App\Zan::class)->orderBy('created_at', 'desc');
    }

    //一篇文章可能属于多个专题（获取到这篇文章有哪几个专题）
    public function postTopics()
    {
        return $this->hasMany(\App\PostTopic::class, 'post_id', 'id');
    }

    //属于某个作者的文章
    public function scopeAuthorBy(Builder $query, $user_id)
    {
        return $query->where('user_id', $user_id);
    }

    //不属于某个专题的文章
    public function scopeTopicNotBy(Builder $query, $topic_id)
    {
        return $query->doesntHave('postTopics', 'and', function($q) use($topic_id) {
            $q->where('topic_id', $topic_id);
        });
    }

    //全局scope的方式
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope("available", function(Builder $builder) {
            $builder->whereIn("status", [0, 1]);
        });
    }



}

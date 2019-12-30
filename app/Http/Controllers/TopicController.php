<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Topic;

class TopicController extends Controller
{
    //专题详情页
    public function show(Topic $topic)
    {
        //专题下的文章数
        $topic = Topic::withCount('postTopics')->find($topic->id);

        //专题下的文章列表，按倒叙排列前10篇
        $posts = $topic->posts()->orderBy('created_at', 'desc')->take(10)->get();

        //属于我的文章，但是未投稿
        $myposts = \App\Post::authorBy(\Auth::id())->topicNotBy($topic->id)->get();

        return view('topic/show', compact('topic', 'posts', 'myposts'));
    }
    //投稿
    public function submit(Topic $topic)
    {

    }
}

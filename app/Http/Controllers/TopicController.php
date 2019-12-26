<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Topic;

class TopicController extends Controller
{
    //专题详情页
    public function show(Topic $topic)
    {

        return view('topic/show');
    }
    //投稿
    public function submit(Topic $topic)
    {

    }
}

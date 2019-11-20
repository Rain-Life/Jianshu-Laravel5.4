<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * 文章列表页
     *
     * @author chenxingsheng
     * @time 2019-11-19
    */
    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->paginate(6);
        return view('post/index', compact('posts'));
    }
    /**
     * 文章详情页
     *
     * @author chenxingsheng
     * @time 2019-11-19
     */
    public function show(Post $post)
    {
        return view('post/show', compact('post'));
    }
    /**
     * 创建文章页
     *
     * @author chenxingsheng
     * @time 2019-11-19
     */
    public function create()
    {
        return view('post/create');
    }
    /**
     * 创建文章逻辑
     *
     * @author chenxingsheng
     * @time 2019-11-19
     */
    public function store()
    {
        $post = Post::create(request(['title', 'content']));

        return redirect('/posts');
    }
    /**
     * 编辑文章页
     *
     * @author chenxingsheng
     * @time 2019-11-19
     */
    public function edit()
    {
        return view('post/edit');
    }
    /**
     * 编辑文章逻辑
     *
     * @author chenxingsheng
     * @time 2019-11-19
     */
    public function update()
    {

    }
    /**
     * 删除文章
     *
     * @author chenxingsheng
     * @time 2019-11-19
     */
    public function delete()
    {

    }
}

<?php

namespace App\Http\Controllers;

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

        return view('post/index');
    }
    /**
     * 文章详情页
     *
     * @author chenxingsheng
     * @time 2019-11-19
     */
    public function show()
    {
        return view('post/show');
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

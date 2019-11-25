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
        //验证
        $this->validate(request(), [
            'title' => 'required|string|max:100|min:5',
            'content' => 'required|string|min:10'
        ]);

        $user_id = \Auth::id();
        $params = array_merge(request(['title', 'content']), compact('user_id'));
        $post = Post::create($params);

        return redirect('/posts');
    }
    /**
     * 编辑文章页
     *
     * @author chenxingsheng
     * @time 2019-11-19
     */
    public function edit(Post $post)
    {
        return view('post/edit', compact('post'));
    }
    /**
     * 编辑文章逻辑
     *
     * @author chenxingsheng
     * @time 2019-11-19
     */
    public function update(Post $post)
    {
        //验证
        $this->validate(request(), [
            'title' => 'required|string|max:100|min:5',
            'content' => 'required|string|min:10'
        ]);

        $this->authorize('update', $post);

        $post->title = request('title');
        $post->content = request('content');
        $post->save();

        return redirect("/posts/{$post->id}");
    }
    /**
     * 删除文章
     *
     * @author chenxingsheng
     * @time 2019-11-19
     */
    public function delete(Post $post)
    {
        $this->authorize('delete', $post);

        $post->delete();

        return redirect('/posts');
    }
    /**
     * 图片上传
    */
    public function imageUpload(Request $request)
    {
        $path = $request->file('wangEditorH5File')->storePublicly(md5(time()));
        return asset('storage/' . $path);
    }
}

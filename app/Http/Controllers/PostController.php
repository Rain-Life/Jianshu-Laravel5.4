<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Post;
use App\Zan;
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
        $posts = Post::orderBy('created_at', 'desc')
            ->withCount("comments")
            ->paginate(6);
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
        $post->load('comments');
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
     *
     * @author chenxingsheng
     * @time 2019-11-19
    */
    public function imageUpload(Request $request)
    {
        $path = $request->file('wangEditorH5File')->storePublicly(md5(time()));
        return asset('storage/' . $path);
    }

    /**
     * 提交评论
     *
     * @author chenxingsheng
     * @time 2019-11-26
    */
    public function comment(Post $post)
    {
        $this->validate(request(), [
            'content' => 'required|min:3',
        ]);

        $comment = new Comment();
        $comment->user_id = \Auth::id();
        $comment->content = request('content');
        $post->comments()->save($comment);
    }

    /**
     * 点赞
     *
     * @author chenxingsheng
     * @time 2019-11-26
    */
    public function zan(Post $post)
    {
        $param = [
            'user_id' => \Auth::id(),
            'post_id' => $post->id,
        ];

        Zan::firstOrCreate($param);//此方法意为，有该记录就查询出来，没有就插入
        return back();
    }

    /**
     * 取消赞
     *
     * @author chenxingsheng
     * @time 2019-11-26
    */
    public function unzan(Post $post)
    {
        $post->zan(\Auth::id())->delete();
        return back();
    }
}

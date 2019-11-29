@extends("layout.main")
@section("content")
<div class="alert alert-success" role="alert">
    下面是搜索"{{$query}}"出现的文章，共{{$posts->total()}}条
</div>

<div class="col-sm-8 blog-main">
            @foreach($posts as $item)
            <div class="blog-post">
                <h2 class="blog-post-title"><a href="/posts/{{$item->id}}" >{{$item->title}}</a></h2>
                <p class="blog-post-meta">{{$item->created_at->toFormattedDateString()}} by <a href="/user/5">{{$item->user->name}}</a></p>

                {!! str_limit($item->content, 100, '...') !!}</div>
            @endforeach
            {{$posts->links()}}
        </div><!-- /.blog-main -->
@endsection
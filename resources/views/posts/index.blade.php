<h1>A list of posts</h1>
<ul>
    @foreach($posts as $post)
        <li class="post-item"><a href="{{ route('postSingle', ['slug' => $post->slug]) }}">{{ $post->title }}</a></li>
    @endforeach
</ul>
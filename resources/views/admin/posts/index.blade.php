<h1>A list of posts</h1>
<ul>
    @foreach($posts as $post)
        <li class="post-item">
            <a href="{{ route('postSingle', ['slug' => $post->slug]) }}">{{ $post->title }}</a>
            <form action="{{ route('deletePost', ['id' => $post->id]) }}">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <input type="hidden" value="{{ $post->id }}">
                <button name="delete-post-#{{ $post->id }}">Delete</button>
            </form>
        </li>
    @endforeach
</ul>
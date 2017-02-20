<h1>{{ $post->title }}</h1>
<h3>{{ $post->category->name }}</h3>
<p>{{ $post->body }}</p>
@if(count($post->tags))
    <ul>
        @foreach($post->tags as $tag)
            <li>{{ $tag->name }}</li>
        @endforeach
    </ul>
@endif
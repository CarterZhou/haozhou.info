<h1>A list of articles</h1>
<ul>
    @foreach($articles as $article)
        <li class="article-item"><a href="{{ route('articleSingle', ['slug' => $article->slug]) }}">{{ $article->title }}</a></li>
    @endforeach
</ul>
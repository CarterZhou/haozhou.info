<h1>A list of articles</h1>
<ul>
    @foreach($articles as $article)
        <li class="article-item">{{ $article->title }}</li>
    @endforeach
</ul>
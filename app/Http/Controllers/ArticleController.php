<?php

namespace App\Http\Controllers;

use App\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::trending();

        return view('articles.index', compact('articles'));
    }

    public function show(Request $request)
    {
        $article = Article::select(['title','views'])
            ->where('slug', $request->route('slug'))
            ->first();

        return view('articles.show', compact('article'));
    }
}

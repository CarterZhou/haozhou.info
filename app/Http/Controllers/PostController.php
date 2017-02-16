<?php

namespace App\Http\Controllers;

use App\Post;
use App\Http\Requests\CreateArticle;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::recent();

        return view('posts.index', compact('posts'));
    }

    public function show(Request $request)
    {
        $post = Post::select(['title', 'body', 'views'])
            ->where('slug', $request->route('slug'))
            ->first();

        return view('posts.show', compact('post'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(CreateArticle $request)
    {
        Post::create([
            'title' => $request->input('title'),
            'body' => $request->input('body'),
            'slug' => str_slug($request->input('title'))
        ]);

        return redirect('/posts');
    }
}

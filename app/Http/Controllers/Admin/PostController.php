<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateArticle;
use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::recent();

        return view('admin.posts.index', compact('posts'));
    }

    public function show(Request $request)
    {
        $post = Post::select(['title', 'body', 'views'])
            ->where('slug', $request->route('slug'))
            ->first();

        return view('admin.posts.show', compact('post'));
    }

    public function create()
    {
        return view('admin.posts.create');
    }

    public function store(CreateArticle $request)
    {
        Post::create([
            'title' => $request->input('title'),
            'body' => $request->input('body'),
            'slug' => str_slug($request->input('title'))
        ]);

        return redirect('/admin/posts');
    }

    public function delete(Request $request)
    {
        Post::destroy($request->input('id'));

        return redirect('/admin/posts');
    }
}

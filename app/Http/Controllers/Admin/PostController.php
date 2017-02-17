<?php

namespace App\Http\Controllers\Admin;

use App\Category;
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
        $post = Post::select(['id', 'title', 'body', 'views', 'category_id'])
            ->where('slug', $request->route('slug'))
            ->first();

        return view('admin.posts.show', compact('post'));
    }

    public function create()
    {
        $categories = Category::all(['id' , 'name']);

        return view('admin.posts.create', compact('categories'));
    }

    public function store(CreateArticle $request)
    {
        $post = Post::create([
            'title' => $request->input('title'),
            'body' => $request->input('body'),
            'slug' => str_slug($request->input('title'))
        ]);

        $category = Category::findOrFail($request->input('category'));

        $category->add($post);

        return redirect('/admin/posts');
    }

    public function delete(Request $request)
    {
        Post::destroy($request->input('id'));

        return redirect('/admin/posts');
    }
}

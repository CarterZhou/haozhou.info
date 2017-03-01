<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateOrUpdatePost;
use App\Post;
use App\Tag;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::recent();

        return view('admin.post.index', compact('posts'));
    }

    public function createView()
    {
        $categories = Category::all(['id', 'name']);
        $tags = Tag::all(['id', 'name']);

        return view('admin.post.create', compact('categories', 'tags'));
    }

    public function create(CreateOrUpdatePost $request)
    {
        $post = Post::create([
            'title' => $request->input('title'),
            'body' => $request->input('body'),
            'slug' => str_slug($request->input('title')),
            'uuid' => str_random(15)
        ]);

        if ($request->has('tags')) {
            $post->addTags(Tag::select(['id'])->whereIn('id', $request->input('tags'))->get());
        }

        $category = Category::findOrFail($request->input('category'));
        $category->addPosts($post);

        return redirect()->route('postList');
    }

    public function updateView(Request $request)
    {
        $categories = Category::all(['id', 'name']);
        $tags = Tag::all(['id', 'name']);


        $post = Post::select(['id', 'title', 'body', 'views', 'category_id'])
            ->where('id', $request->route('id'))
            ->first();

        $postTagIds = $post->tags->pluck('id')->all();

        return view('admin.post.update', compact('post', 'categories', 'tags', 'postTagIds'));
    }

    public function update(CreateOrUpdatePost $request)
    {
        $post = Post::findOrFail($request->route('id'));

        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->category_id = $request->input('category');

        $post->save();

        if ($request->has('tags')) {
            $post->addTags(Tag::select(['id'])->whereIn('id', $request->input('tags'))->get());
        }

        return redirect()->route('postList');
    }

    public function delete(Request $request)
    {
        Post::destroy($request->input('id'));

        return redirect()->route('postList');
    }
}

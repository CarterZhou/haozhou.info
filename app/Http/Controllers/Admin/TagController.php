<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateOrUpdateTag;
use App\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * TagController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $tags = Tag::all(['id', 'name', 'created_at', 'updated_at']);

        return view('admin.tag.index', compact('tags'));
    }

    public function createView()
    {
        return view('admin.tag.create');
    }

    public function create(CreateOrUpdateTag $request)
    {
        Tag::create([
            'name' => $request->input('name')
        ]);

        return redirect()->route('tagList');
    }

    public function updateView(Request $request)
    {
        $tag = Tag::findOrFail($request->route('id'));

        return view('admin.tag.update', compact('tag'));
    }

    public function update(CreateOrUpdateTag $request)
    {
        $tag = Tag::findOrFail($request->route('id'));
        $tag->name = $request->input('name');
        $tag->save();

        return redirect()->route('tagList');
    }

    public function delete(Request $request)
    {
        $tag = Tag::findOrFail($request->route('id'));
        $tag->remove();

        return redirect()->route('tagList');
    }
}

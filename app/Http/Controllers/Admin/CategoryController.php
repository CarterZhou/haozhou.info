<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateOrUpdateCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all(['id', 'name', 'created_at', 'updated_at']);

        return view('admin.category.index', compact('categories'));
    }

    public function createView()
    {
        return view('admin.category.create');
    }

    public function create(CreateOrUpdateCategory $request)
    {
        Category::create([
            'name' => $request->input('name')
        ]);

        return redirect()->route('categoryList');
    }

    public function updateView(Request $request)
    {
        $category = Category::findOrFail($request->route('id'));

        return view('admin.category.update', compact('category'));
    }

    public function update(CreateOrUpdateCategory $request)
    {
        $category = Category::findOrFail($request->route('id'));
        $category->name = $request->input('name');
        $category->save();

        return redirect()->route('categoryList');
    }

    public function delete(Request $request)
    {
        $category = Category::findOrFail($request->input('id'));
        $category->remove();

        return redirect()->route('categoryList');
    }

}
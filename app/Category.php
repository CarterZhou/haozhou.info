<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = ['id'];

    public function addPosts($posts)
    {
        if ($posts instanceof Post) {
            return $this->posts()->save($posts);
        }
        return $this->posts()->saveMany($posts);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function removePosts($posts = null)
    {
        if ($posts instanceof Post) {
            $posts->category()->dissociate();
            return $posts->save();
        }
        return $this->posts()->update(['category_id' => null]);
    }

    public function remove()
    {
         $this->removePosts();
        return Category::destroy($this->id);
    }
}

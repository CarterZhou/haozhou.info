<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = ['id'];

    public function add($articles)
    {
        if ($articles instanceof Article) {
            return $this->articles()->save($articles);
        }
        return $this->articles()->saveMany($articles);
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function remove(Article $article)
    {
        $article->category()->dissociate();
        $article->save();
    }

    public function removeAll()
    {
        $this->articles()->update(['category_id' => null]);
    }
}

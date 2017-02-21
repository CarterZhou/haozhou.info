<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $guarded = ['id'];

    public function scopeTrending()
    {
        return Post::select(['id', 'title', 'slug', 'views'])
            ->orderBy('views', 'desc')
            ->get();
    }

    public function scopeRecent()
    {
        return Post::select(['id', 'title', 'slug', 'views', 'created_at'])
            ->latest()
            ->get();
    }

    public function addTags($tags = null)
    {
        $ids = [];
        foreach ($tags as $tag) {
            $ids[] = $tag->id;
        }
        $this->tags()->sync($ids);
    }

    public function removeTags()
    {
        $this->addTags();
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $guarded = ['id'];

    public function scopeTrending()
    {
        return Post::select(['id', 'title', 'slug', 'views', 'uuid'])
            ->orderBy('views', 'desc')
            ->get();
    }

    public function scopeRecent()
    {
        return Post::select(['id', 'title', 'slug', 'views','uuid', 'created_at'])
            ->latest()
            ->get();
    }

    public function addTags($tags = null)
    {
        if ($tags instanceof Tag)
        {
            $collection = new Collection();
            return $this->tags()->sync($collection->push($tags));
        }
        return $this->tags()->sync($tags);
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

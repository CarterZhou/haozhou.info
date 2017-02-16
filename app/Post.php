<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $guarded = ['id'];

    public function scopeTrending()
    {
        return Post::select(['title', 'slug', 'views'])
            ->orderBy('views', 'desc')
            ->get();
    }

    public function scopeRecent()
    {
        return Post::select(['title', 'slug', 'views'])
            ->latest()
            ->get();
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $guarded = ['id'];

    public function scopeTrending()
    {
        return Article::select(['title', 'views'])
            ->orderBy('views', 'desc')
            ->get();
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}

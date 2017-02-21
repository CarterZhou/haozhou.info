<?php

use App\Category;
use App\Post;
use App\Tag;
use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::truncate();
        Post::truncate();
        Tag::truncate();

        $categories = factory(Category::class, 5)->create();
        factory(Tag::class, 5)->create();
        factory(Post::class, 10)->create()->each(function($p) use ($categories) {
            $categories[0]->add($p);
        });
    }
}

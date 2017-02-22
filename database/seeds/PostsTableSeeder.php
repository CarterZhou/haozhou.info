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
        $faker = Faker\Factory::create();

        Category::truncate();
        Post::truncate();
        Tag::truncate();

        $categories = factory(Category::class, 5)->create();
        factory(Tag::class, 5)->create();
        factory(Post::class, 10)->create()->each(function($p) use ($faker, $categories) {
            $p->views = $faker->numberBetween(1,100);
            $p->save();
            $categories[0]->add($p);
        });
    }
}

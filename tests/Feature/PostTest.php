<?php

namespace Tests\Feature;

use App\Category;
use App\Post;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PostTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_fetches_trending_posts()
    {
        factory(Post::class, 2)->create();
        factory(Post::class)->create(['views' => 20]);

        $articles = Post::trending();
        $this->assertEquals(20, $articles->first()->views);
    }
}

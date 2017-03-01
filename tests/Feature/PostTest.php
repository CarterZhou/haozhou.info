<?php

namespace Tests\Feature;

use App\Category;
use App\Post;
use App\Tag;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PostTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_can_fetch_trending_posts()
    {
        factory(Post::class, 2)->create();
        factory(Post::class)->create(['views' => 20]);

        $articles = Post::trending();
        $this->assertEquals(20, $articles->first()->views);
    }

    /** @test */
    public function it_can_add_one_tag_to_to_a_post()
    {
        $post = factory(Post::class)->create();
        $tag = factory(Tag::class)->create();

        $post->addTags($tag);
        $this->assertEquals(1, $post->tags()->count());
    }

    /** @test */
    public function it_can_add_multiple_tags_to_a_post()
    {
        $post = factory(Post::class)->create();
        $tags = factory(Tag::class, 5)->create();

        $post->addTags($tags);
        $this->assertEquals(5, $post->tags()->count());
    }
}

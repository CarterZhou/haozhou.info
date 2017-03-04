<?php

namespace Tests\Feature;

use App\Post;
use App\Tag;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TagTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_can_remove_a_tag_that_has_posts_associated_with()
    {
        $post = factory(Post::class)->create();
        $tags = factory(Tag::class, 5)->create();
        $firstTag = $tags[0];

        $post->addTags($tags);
        $firstTag->remove();
        $tags = Tag::all();

        $this->assertEquals(4, $post->tags()->count());
        $this->assertCount(4, $tags);
    }
}

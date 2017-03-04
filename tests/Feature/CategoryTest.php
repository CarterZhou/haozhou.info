<?php

namespace Tests\Feature;

use App\Post;
use App\Category;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CategoryTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_can_add_a_post()
    {
        $category = factory(Category::class)->create();
        $post = factory(Post::class)->create();

        $category->addPosts($post);

        $this->assertEquals(1, $category->posts()->count());
    }

    /** @test */
    public function it_can_add_multiple_posts_at_once()
    {
        $category = factory(Category::class)->create();
        $posts = factory(Post::class, 5)->create();

        $category->addPosts($posts);

        $this->assertEquals(5, $category->posts()->count());
    }

    /** @test */
    public function it_can_remove_an_article()
    {
        $category = factory(Category::class)->create();
        $posts = factory(Post::class, 5)->create();
        $category->addPosts($posts);

        $category->removePosts($posts[0]);

        $this->assertEquals(4, $category->posts()->count());
    }

    /** @test */
    public function it_can_remove_all_articles_at_once()
    {
        $category = factory(Category::class)->create();
        $posts = factory(Post::class, 5)->create();
        $category->addPosts($posts);

        $category->removePosts();

        $this->assertEquals(0, $category->posts()->count());
    }

    /** @test */
    public function it_can_remove_a_category_that_have_posts_associated_with()
    {
        $categories = factory(Category::class, 5)->create();
        $firstCategory = $categories[0];
        $posts = factory(Post::class, 5)->create();
        $firstCategory->addPosts($posts);

        $firstCategory->remove();
        $categories = Category::all();

        $this->assertCount(4, $categories);
     }
}
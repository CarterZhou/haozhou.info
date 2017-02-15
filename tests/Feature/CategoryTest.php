<?php

namespace Tests\Feature;

use App\Article;
use App\Category;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CategoryTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_can_add_an_article()
    {
        $category = factory(Category::class)->create();
        $article = factory(Article::class)->create();

        $category->add($article);

        $this->assertEquals(1, $category->articles()->count());
    }

    /** @test */
    public function it_can_add_multiple_articles_at_once()
    {
        $category = factory(Category::class)->create();
        $articles = factory(Article::class, 5)->create();

        $category->add($articles);

        $this->assertEquals(5, $category->articles()->count());
    }

    /** @test */
    public function it_can_remove_an_article()
    {
        $category = factory(Category::class)->create();
        $articles = factory(Article::class, 5)->create();
        $category->add($articles);

        $category->remove($articles[0]);

        $this->assertEquals(4, $category->articles()->count());
    }

    /** @test */
    public function it_can_remove_all_articles_at_once()
    {
        $category = factory(Category::class)->create();
        $articles = factory(Article::class, 5)->create();
        $category->add($articles);

        $category->removeAll();

        $this->assertEquals(0, $category->articles()->count());
    }
}
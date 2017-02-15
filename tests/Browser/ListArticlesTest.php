<?php

namespace Tests\Browser;

use App\Article;
use Facebook\WebDriver\WebDriverBy;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ListArticlesTest extends DuskTestCase
{
    use DatabaseMigrations;

    protected $articles;

    public function setUp()
    {
        parent::setUp();
        $this->articles = factory(Article::class, 10)->create();
    }

    /** @test */
    public function user_can_see_a_list_of_articles()
    {
        $this->browse(function ($browser) {
            $browser->visit('/articles');
            $elements = $browser->driver->findElements(WebDriverBy::className('article-item'));
            $this->assertCount(10, $elements);
        });
    }

    /** @test */
    public function after_clicking_link_to_an_article_user_can_see_its_content()
    {
        $article = $this->articles[0];
        $this->browse(function ($browser) use ($article) {
            $browser->visit('/articles')
                ->assertSee($article->title)
                ->clickLink($article->title)
                ->assertPathIs('/articles/' . $article->slug)
                ->assertSee($article->title);
        });
    }
}

<?php

namespace Tests\Browser;

use App\Article;
use Facebook\WebDriver\WebDriverBy;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ListArticlesTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();
        factory(Article::class, 10)->create();
    }

    /** @test */
    public function it_displays_a_list_of_articles()
    {
        $this->browse(function ($browser) {
            $browser->visit('/articles');
            $elements = $browser->driver->findElements(WebDriverBy::className('article-item'));
            $this->assertCount(10, $elements);
        });
    }
}

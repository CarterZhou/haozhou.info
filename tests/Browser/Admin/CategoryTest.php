<?php

namespace Tests\Browser\Admin;

use App\Category;
use Facebook\WebDriver\WebDriverBy;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CategoryTest extends DuskTestCase
{
    use DatabaseMigrations;

    protected $categories;

    public function setUp()
    {
        parent::setUp();
        $this->categories = factory(Category::class, 10)->create();
    }

    /** @test */
    public function user_can_see_a_list_of_categories()
    {
        $this->browse(function ($browser) {
            $browser->visit('/admin/categories');
            $elements = $browser->driver->findElements(WebDriverBy::className('category-item'));
            $this->assertCount(10, $elements);
        });
    }
}

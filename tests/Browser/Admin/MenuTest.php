<?php

namespace Tests\Browser\Admin;

use App\Category;
use App\Post;
use App\Tag;
use App\User;
use Facebook\WebDriver\WebDriverBy;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class MenuTest extends DuskTestCase
{
    use DatabaseMigrations;

    protected $posts;
    protected $categories;
    protected $tags;

    public function setUp()
    {
        parent::setUp();
        factory(User::class)->create();
        $this->categories = factory(Category::class, 5)->create();
        $this->tags = factory(Tag::class, 5)->create();
        $this->posts = factory(Post::class, 10)->create()->each(function($p) {
            $this->categories[0]->addPosts($p);
            $p->addTags($this->tags[0]);
        });
    }

    /**
     * @test
     * @group admin_menu
     */
    public function user_can_go_to_dashboard_page()
    {
        $this->browse(function ($browser) {
           $browser->loginAs(User::find(1))
               ->visit('/admin/posts')
               ->assertSee('Dashboard')
               ->clickLink('Dashboard')
               ->assertPathIs('/admin');
        });
    }

    /**
     * @test
     * @group admin_menu
     */
    public function user_can_go_to_post_index_page()
    {
        $this->browse(function ($browser) {
           $browser->loginAs(User::find(1))
               ->visit('/admin')
               ->assertSee('Blog')
               ->clickLink('Blog');

           $browser->waitForText('Post')
               ->clickLink('Post')
               ->assertPathIs('/admin/posts');

            $elements = $browser->driver->findElements(WebDriverBy::className('post-item'));
            $this->assertCount(10, $elements);
        });
    }

    /**
     * @test
     * @group admin_menu
     */
    public function user_can_go_to_category_index_page()
    {
        $this->browse(function ($browser) {
            $browser->loginAs(User::find(1))
                ->visit('/admin')
                ->assertSee('Blog')
                ->clickLink('Blog');

            $browser->waitForText('Category')
                ->clickLink('Category')
                ->assertPathIs('/admin/categories');

            $elements = $browser->driver->findElements(WebDriverBy::className('category-item'));
            $this->assertCount(5, $elements);
        });
    }

    /**
     * @test
     * @group admin_menu
     */
    public function user_can_go_to_tag_index_page()
    {
        $this->browse(function ($browser) {
            $browser->loginAs(User::find(1))
                ->visit('/admin')
                ->assertSee('Blog')
                ->clickLink('Blog');

            $browser->waitForText('Tag')
                ->clickLink('Tag')
                ->assertPathIs('/admin/tags');

            $elements = $browser->driver->findElements(WebDriverBy::className('tag-item'));
            $this->assertCount(5, $elements);
        });
    }
}

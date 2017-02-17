<?php

namespace Tests\Browser\Admin;

use App\Category;
use App\Post;
use Facebook\WebDriver\WebDriverBy;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class PostTest extends DuskTestCase
{
    use DatabaseMigrations;

    protected $posts;
    protected $categories;

    public function setUp()
    {
        parent::setUp();
        $this->categories = factory(Category::class, 5)->create();
        $this->posts = factory(Post::class, 10)->create()->each(function($p) {
            $this->categories[0]->add($p);
        });
    }

    /** @test */
    public function user_can_see_a_list_of_posts()
    {
        $this->browse(function ($browser) {
            $browser->visit('/admin/posts');
            $elements = $browser->driver->findElements(WebDriverBy::className('post-item'));
            $this->assertCount(10, $elements);
        });
    }

    /** @test */
    public function after_clicking_link_to_a_post_user_can_see_its_content()
    {
        $post = $this->posts[0];
        $this->browse(function ($browser) use ($post) {
            $browser->visit('/admin/posts')
                ->clickLink($post->title)
                ->assertPathIs('/admin/posts/' . $post->slug)
                ->assertSee($post->title)
                ->assertSee($post->body);
        });
    }

    /** @test */
    public function user_can_create_a_new_post()
    {
        $categorySelected = $this->categories[0];

        $data = [
            'title' => 'Testing',
            'body' => 'This is a post for testing.',
            'categoryId' => $categorySelected->id
        ];

        $this->browse(function ($browser) use ($data, $categorySelected) {
           $browser->visit('/admin/posts/create')
               ->type('title', $data['title'])
               ->type('body', $data['body'])
               ->select('category', $data['categoryId'])
               ->press('Create')
               ->assertPathIs('/admin/posts')
               ->clickLink($data['title'])
               ->assertSee($data['title'])
               ->assertSee($categorySelected->name);
        });
    }

    /** @test */
    public function user_cannot_create_a_new_post_with_invalid_input()
    {
        $invalidData = [
            'title' => '',
            'body' => ''
        ];

        $this->browse(function ($browser) use ($invalidData) {
            $browser->visit('/admin/posts/create')
                ->type('title', $invalidData['title'])
                ->type('body', $invalidData['body'])
                ->press('Create')
                ->assertPathIs('/admin/posts/create')
                ->assertSee('The title field is required')
                ->assertSee('The body field is required');
        });
    }
    /** @test */
    public function user_can_delete_a_post()
    {
        $post = $this->posts[0];

        $this->browse(function ($browser) use ($post) {
            $browser->visit('/admin/posts')
                ->assertSee($post->title)
                ->press("delete-post-#{$post->id}")
                ->assertDontSee($post->title);
        });
    }
}

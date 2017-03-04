<?php

namespace Tests\Browser\Admin;

use App\Post;
use App\Tag;
use Facebook\WebDriver\WebDriverBy;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class TagTest extends DuskTestCase
{
    use DatabaseMigrations;

    protected $tags;
    protected $post;

    public function setUp()
    {
        parent::setUp();
        $this->tags = factory(Tag::class, 10)->create();
        $this->post = factory(Post::class)->create();

        $this->post->addTags($this->tags);
    }

    /** @test */
    public function user_can_see_a_list_of_tags()
    {
        $this->browse(function ($browser) {
            $browser->visit('/admin/tags');
            $elements = $browser->driver->findElements(WebDriverBy::className('tag-item'));
            $this->assertCount(10, $elements);
        });
    }

    /** @test */
    public function user_can_create_a_new_tag()
    {
        $data = [
            'name' => 'A testing tag name'
        ];

        $this->browse(function ($browser) use($data) {
           $browser->visit('/admin/tags')
               ->clickLink('New')
               ->assertPathIs('/admin/tags/create')
               ->type('name', $data['name'])
               ->press('Create')
               ->assertPathIs('/admin/tags')
               ->assertSee($data['name']);
           $elements = $browser->driver->findElements(WebDriverBy::className('tag-item'));
           $this->assertCount(11, $elements);
        });
    }

    /** @test */
    public function user_cannot_create_tag_with_invalid_input()
    {
        $invalidData = [
            'name' => ''
        ];

        $this->browse(function ($browser) use($invalidData) {
            $browser->visit('/admin/tags')
                ->clickLink('New')
                ->assertPathIs('/admin/tags/create')
                ->type('name', $invalidData['name'])
                ->press('Create')
                ->assertPathIs('/admin/tags/create')
                ->assertSee('The name field is required');
        });
    }

    /** @test */
    public function user_can_update_a_tag()
    {
        $tag = $this->tags[0];

        $data = [
            'name' => 'Changed name'
        ];

        $this->browse(function ($browser) use($tag, $data) {
           $browser->visit('/admin/tags')
               ->click("#update-tag-{$tag->id}")
               ->assertSee($tag->name)
               ->type('name', $data['name'])
               ->press('Update')
               ->assertPathIs('/admin/tags')
               ->click("#update-tag-{$tag->id}")
               ->assertSee($data['name']);
        });
    }

    /** @test */
    public function user_can_delete_a_tag()
    {
        $tag = $this->tags[0];

        $this->browse(function ($browser) use ($tag) {
            $browser->visit('/admin/tags')
                ->assertSee($tag->name)
                ->press("delete-tag-{$tag->id}");
            $browser->driver->switchTo()->alert()->accept();

            $browser->assertPathIs('/admin/tags')->assertDontSee($tag->name);
            $elements = $browser->driver->findElements(WebDriverBy::className('tag-item'));
            $this->assertCount(9, $elements);
        });
    }

    /** @test */
    public function user_can_cancel_deleting_a_tag()
    {
        $tag = $this->tags[0];

        $this->browse(function ($browser) use ($tag) {
            $browser->visit('/admin/tags')
                ->assertSee($tag->name)
                ->press("delete-tag-{$tag->id}");
            $browser->driver->switchTo()->alert()->dismiss();
            $browser->assertSee($tag->name);
        });
    }
}
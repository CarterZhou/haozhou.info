<?php

namespace Tests\Browser\Admin;

use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class MenuTest extends DuskTestCase
{
    /** @test */
    public function user_can_go_to_post_index_page()
    {
        $this->browse(function ($browser) {
           $browser->visit('/admin')
               ->assertSee('Blog')
               ->clickLink('Blog');

           $browser->waitForText('Post')
               ->clickLink('Post')
               ->assertPathIs('/admin/posts');
        });
    }

    /** @test */
    public function user_can_go_to_category_index_page()
    {
        $this->browse(function ($browser) {
            $browser->visit('/admin')
                ->assertSee('Blog')
                ->clickLink('Blog');

            $browser->waitForText('Category')
                ->clickLink('Category')
                ->assertPathIs('/admin/categories');
        });
    }

    /** @test */
    public function user_can_go_to_tag_index_page()
    {
        $this->browse(function ($browser) {
            $browser->visit('/admin')
                ->assertSee('Blog')
                ->clickLink('Blog');

            $browser->waitForText('Tag')
                ->clickLink('Tag')
                ->assertPathIs('/admin/tags');
        });
    }
}

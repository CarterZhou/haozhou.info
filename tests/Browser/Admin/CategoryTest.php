<?php

namespace Tests\Browser\Admin;

use App\Category;
use App\Post;
use App\User;
use Facebook\WebDriver\WebDriverBy;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\DuskTestCase;

class CategoryTest extends DuskTestCase
{
    use DatabaseMigrations;

    protected $categories;

    public function setUp()
    {
        parent::setUp();
        factory(User::class)->create();
        $this->categories = factory(Category::class, 10)->create();
        $this->categories[0]->addPosts(factory(Post::class)->create());
    }

    /**
     * @test
     * @group admin_category
     */
    public function user_can_see_a_list_of_categories()
    {
        $this->browse(function ($browser) {
            $browser->loginAs(User::find(1))->visit('/admin/categories');
            $elements = $browser->driver->findElements(WebDriverBy::className('category-item'));
            $this->assertCount(10, $elements);
        });
    }

    /**
     * @test
     * @group admin_category
     */
    public function user_can_create_a_new_category()
    {
        $data = [
            'name' => 'Testing category name'
        ];

        $this->browse(function ($browser) use ($data) {
            $browser->loginAs(User::find(1))
                ->visit('/admin/categories')
                ->clickLink('New')
                ->assertPathIs('/admin/categories/create')
                ->type('name', $data['name'])
                ->press('Create')
                ->assertPathIs('/admin/categories')
                ->assertSee($data['name']);
        });
    }

    /**
     * @test
     * @group admin_category
     */
    public function user_cannot_create_category_with_invalid_input()
    {
        $invalidData = [
            'name' => ''
        ];

        $this->browse(function ($browser) use ($invalidData) {
            $browser->loginAs(User::find(1))
                ->visit('/admin/categories')
                ->clickLink('New')
                ->assertPathIs('/admin/categories/create')
                ->type('name', $invalidData['name'])
                ->press('Create')
                ->assertPathIs('/admin/categories/create')
                ->assertSee('The name field is required');
        });
    }

    /**
     * @test
     * @group admin_category
     */
    public function user_can_update_a_category()
    {
        $category = $this->categories[0];

        $data = [
            'name' => 'Changed category name'
        ];

        $this->browse(function ($browser) use ($category, $data) {
            $browser->loginAs(User::find(1))
                ->visit('/admin/categories')
                ->click("#update-category-{$category->id}")
                ->assertSee($category->name)
                ->type('name', $data['name'])
                ->press('Update')
                ->assertPathIs('/admin/categories')
                ->click("#update-category-{$category->id}")
                ->assertSee($data['name']);
        });
    }

    /**
     * @test
     * @group admin_category
     */
    public function user_can_delete_a_category()
    {
        $category = $this->categories[0];

        $this->browse(function ($browser) use ($category) {
            $browser->loginAs(User::find(1))
                ->visit('/admin/categories')
                ->assertSee($category->name)
                ->press("delete-category-{$category->id}");
            $browser->driver->switchTo()->alert()->accept();

            $browser->assertPathIs('/admin/categories')->assertDontSee($category->name);
            $elements = $browser->driver->findElements(WebDriverBy::className('category-item'));
            $this->assertCount(9, $elements);
        });
    }

    /**
     * @test
     * @group admin_category
     */
    public function user_can_cancel_deleting_a_category()
    {
        $category = $this->categories[0];

        $this->browse(function ($browser) use ($category) {
            $browser->loginAs(User::find(1))
                ->visit('/admin/categories')
                ->assertSee($category->name)
                ->press("delete-category-{$category->id}");
            $browser->driver->switchTo()->alert()->dismiss();
            $browser->assertSee($category->name);
        });
    }
}

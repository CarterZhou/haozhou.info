<?php

namespace Tests\Browser\Admin;

use App\Category;
use App\Post;
use App\Tag;
use App\User;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverSelect;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class PostTest extends DuskTestCase
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
     * @group admin_post
     */
    public function user_can_see_a_list_of_posts()
    {
        $this->browse(function ($browser) {
            $browser->loginAs(User::find(1))->visit('/admin/posts');
            $elements = $browser->driver->findElements(WebDriverBy::className('post-item'));
            $this->assertCount(10, $elements);
        });
    }

    /**
     * @test
     * @group admin_post
     */
    public function user_can_choose_more_than_one_tag_when_tagging_a_post_upon_creating_it()
    {
        $categorySelected = $this->categories[0];
        $tagOne = $this->tags[0];
        $tagTwo = $this->tags[1];

        $data = [
            'title' => 'Testing tagging',
            'body' => 'This is a post for testing tagging.',
            'categoryId' => $categorySelected->id,
            'tagOne' => $tagOne->id,
            'tagTwo' => $tagTwo->id
        ];

        $this->browse(function ($browser) use ($data, $categorySelected, $tagOne, $tagTwo) {

            $browser->loginAs(User::find(1))
                ->visit('/admin/posts/create')
                ->type('title', $data['title'])
                ->select('category', $data['categoryId']);

            $browser->driver->switchTo()->frame('body_ifr');
            $editorBody = $browser->driver->findElement(WebDriverBy::tagName('body'));
            $browser->driver->executeScript("arguments[0].innerHTML = '{$data["body"]}';", [$editorBody]);
            $browser->driver->switchTo()->defaultContent();

            $tagSelect = new WebDriverSelect($browser->driver->findElement(WebDriverBy::id('tags')));
            $tagSelect->selectByValue($data['tagOne']);
            $tagSelect->selectByValue($data['tagTwo']);

            $browser->press('Create')->assertPathIs('/admin/posts');

            $linkToNewPost = $browser->driver->findElements(WebDriverBy::className('link-to-post'))[0];
            $linkToNewPost->click();

            $browser->assertSee($data['title'])
                ->assertSee($categorySelected->name)
                ->assertSee($tagOne->name)
                ->assertSee($tagTwo->name);

            $browser->driver->switchTo()->frame('body_ifr');
            $browser->assertSee($data['body']);
        });
    }

    /**
     * @test
     * @group admin_post
     */
    public function user_cannot_create_a_new_post_with_invalid_input()
    {
        $invalidData = [
            'title' => '',
            'body' => ''
        ];

        $this->browse(function ($browser) use ($invalidData) {
            $browser->loginAs(User::find(1))
                ->visit('/admin/posts')
                ->clickLink('New')
                ->assertPathIs('/admin/posts/create')
                ->type('title', $invalidData['title']);

            $browser->driver->switchTo()->frame('body_ifr');
            $editorBody = $browser->driver->findElement(WebDriverBy::tagName('body'));
            $browser->driver->executeScript("arguments[0].innerHTML = '{$invalidData["body"]}';", [$editorBody]);
            $browser->driver->switchTo()->defaultContent();

            $browser->press('Create')
                ->assertPathIs('/admin/posts/create')
                ->assertSee('The title field is required')
                ->assertSee('The body field is required');
        });
    }

    /**
     * @test
     * @group admin_post
     */
    public function user_can_update_a_post()
    {
        $categorySelected = $this->categories[0];
        $tagOne = $this->tags[0];
        $post = $this->posts[0];
        $postTags  = $post->tags;

        $data = [
            'title' => 'Changed Title',
            'body' => 'Changed Body',
            'categoryId' => $categorySelected->id,
            'tagOne' => $tagOne->id
        ];

        $this->browse(function ($browser) use($post, $data, $postTags, $categorySelected, $tagOne) {
            $browser->loginAs(User::find(1))
                ->visit('/admin/posts')
                ->click("#update-post-{$post->uuid}")
                ->assertPathIs("/admin/posts/{$post->id}")
                ->assertSee($post->title)
                ->assertSee($post->category->name);

            $browser->driver->switchTo()->frame('body_ifr');
            $browser->assertSee($post->body);
            $browser->driver->switchTo()->defaultContent();

            foreach ($postTags as $postTag) {
                $browser->assertSee($postTag->name);
            }

            $browser->type('title', $data['title'])
                ->select('category', $data['categoryId']);

            $browser->driver->switchTo()->frame('body_ifr');
            $editorBody = $browser->driver->findElement(WebDriverBy::tagName('body'));
            $browser->driver->executeScript("arguments[0].innerHTML = '{$data["body"]}';", [$editorBody]);
            $browser->driver->switchTo()->defaultContent();

            $tagSelect = new WebDriverSelect($browser->driver->findElement(WebDriverBy::id('tags')));
            $tagSelect->selectByValue($data['tagOne']);

            $browser->press('Update')
                ->assertPathIs('/admin/posts')
                ->click("#update-post-{$post->uuid}")
                ->assertSee($data['title'])
                ->assertSee($categorySelected->name)
                ->assertSee($tagOne->name);

            $browser->driver->switchTo()->frame('body_ifr');
            $browser->assertSee($data['body']);
        });
    }

    /**
     * @test
     * @group admin_post
     */
    public function user_can_delete_a_post()
    {
        $post = $this->posts[0];

        $this->browse(function ($browser) use ($post) {
            $browser->loginAs(User::find(1))
                ->visit('/admin/posts')
                ->assertSee($post->title)
                ->press("delete-post-{$post->uuid}");
            $browser->driver->switchTo()->alert()->accept();

            $browser->assertPathIs('/admin/posts')->assertDontSee($post->title);
            $elements = $browser->driver->findElements(WebDriverBy::className('post-item'));
            $this->assertCount(9, $elements);
        });
    }

    /**
     * @test
     * @group admin_post
     */
    public function user_can_cancel_deleting_a_post()
    {
        $post = $this->posts[0];

        $this->browse(function ($browser) use ($post) {
            $browser->loginAs(User::find(1))
                ->visit('/admin/posts')
                ->assertSee($post->title)
                ->press("delete-post-{$post->uuid}");
            $browser->driver->switchTo()->alert()->dismiss();
            $browser->assertSee($post->title);
        });
    }
}

<?php

namespace Tests\Browser\Admin;

use App\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LogoutTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();
        factory(User::class)->create();
    }

    /**
     * @test
     * @group admin_authentication
     */
    public function admin_can_log_out()
    {
        $this->browse(function (Browser $browser) {
            $admin = User::find(1);
            $browser->loginAs($admin)
                ->visit('/admin')
                ->assertSee($admin->name)
                ->clickLink($admin->name)
                ->assertSee('Log Out')
                ->clickLink('Log Out')
                ->assertPathIs('/admin/login')
                ->assertSee('Login Form');
        });
    }
}

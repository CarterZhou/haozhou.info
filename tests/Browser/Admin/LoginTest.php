<?php

namespace Tests\Browser\Admin;

use App\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LoginTest extends DuskTestCase
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
    public function admin_can_login_in()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/login')
                ->type('email', env('ADMIN_EMAIL'))
                ->type('password', env('ADMIN_PASSWORD'))
                ->press('Login')
                ->assertPathIs('/admin');
        });
    }
}

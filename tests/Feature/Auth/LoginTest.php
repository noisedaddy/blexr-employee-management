<?php

namespace Tests\Feature\Auth;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{

    use RefreshDatabase;
    /**
     * test for login view
     *
     * @return void
     */
    public function test_view_a_login_form()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertViewIs('auth.login');

    }

    /**
     * Test for user log in.
     * make a request and assert user was redirected to the homepage.
     */
    public function test_cannot_view_a_login_form_when_authenticated()
    {
        $user = factory(User::class)->make();
        $response = $this->actingAs($user)->get('/login');
        $response->assertRedirect('admin/home');
    }

    /**
     * Loged user
     */
    public function test_can_login_with_credentials()
    {
        $user = factory(User::class)->create([
            'password' => bcrypt($password = '123456'),
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => $password,
        ]);

        $response->assertRedirect('admin/home');
        $this->assertAuthenticatedAs($user);
    }

}

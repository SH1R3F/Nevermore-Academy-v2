<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthenticationTest extends TestCase
{
    /**
     * Unauthenticated user has to be redirected to login page
     *
     * @return void
     */
    public function test_unauthenticated_user_is_redirected_to_login()
    {
        $response = $this->get('/');

        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
    }

    /**
     * Authenticated user can enter dashboard successfully
     *
     * @return void
     */
    public function test_authenticated_user_can_enter_dashboard()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/');

        $response->assertStatus(200);
    }
}

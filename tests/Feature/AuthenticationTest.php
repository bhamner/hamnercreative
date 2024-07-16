<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use Auth;

use Tests\TestCase;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;

class AuthenticationTest extends TestCase
{

    protected $user;

    protected function setUp(): void
    {
      parent::setUp();
      $this->user = User::factory()->make();
      $this->withoutVite();
    }

    /**
     * test sso provider redirect
     */
    public function test_login_attempt_redirects_to_provider(): void
    {
        $this->get('/auth/google')
             ->assertStatus(302);
    }

    /**
     * test dashboard access
     */
 
    public function test_user_can_view_dashboard_authenticated(): void
    {

        $this->actingAs($this->user);
        $this->get('/dashboard')->assertStatus(200);
    }

    /**
     * test dashboard access
     */
 
    public function test_user_cannot_view_dashboard_unauthenticated(): void
    {
        $this->get('/dashboard')->assertRedirect('/');
    }
    

}

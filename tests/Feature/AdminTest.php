<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use Tests\TestCase;
use App\Models\User;

class AdminTest extends TestCase
{

    protected $user;

    protected function setUp(): void
    {
      parent::setUp();
      $this->user = User::factory()->make();
      $this->actingAs($this->user);
      $this->withoutVite();
    }

    /**
     * test dashboard access
     */
 
    public function test_user_can_view_dashboard_authenticated(): void
    {
        $this->get('/dashboard')->assertStatus(200);
    }
 
         

}

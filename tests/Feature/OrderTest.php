<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use Auth;

use Tests\TestCase;
use App\Models\User;
use App\Models\Order;
use Laravel\Socialite\Facades\Socialite;

class OrderTest extends TestCase
{

    protected $user, $order;

    protected function setUp(): void
    {
      parent::setUp();
      $this->user = User::factory()->make();
      $this->order = Order::factory()->make();
      $this->withoutVite();
    }

    /**
     * test orders page is viewable
     */
    public function test_user_can_view_orders_page(): void
    {
        $this->actingAs($this->user)->get('/orders')
             ->assertStatus(200);
    }

    /**
     * test non admin user cannot edit orders
     */
    public function test_user_cannot_see_edit_page(): void
    {
        $this->actingAs($this->user)->get('/order/edit')
             ->assertStatus(403);
    }


    

}

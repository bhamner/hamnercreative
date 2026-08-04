<?php

use App\Models\Content;
use App\Models\Order;

it('only allows a user to delete their own account', function () {
    $user = createUserWithClient();

    $this->actingAs($user)
        ->post(route('user.delete'), [
            'deleteConfirmationCode' => substr($user->vendor_id, 0, 5),
        ])
        ->assertRedirect('/');
});

it('forbids non-admin from cloning orders via post', function () {
    $user = createUserWithClient();
    $order = Order::factory()->create([
        'client_id' => $user->clients()->first()->id,
    ]);

    $this->actingAs($user)
        ->post(route('orders.clone', $order))
        ->assertForbidden();
});

it('forbids deleting content belonging to another client', function () {
    $user = createUserWithClient();
    $content = Content::factory()->create();

    $this->actingAs($user)
        ->post(route('content.delete', $content))
        ->assertForbidden();
});

<?php

use App\Models\Order;

beforeEach(function () {
    $this->withoutVite();
});

it('requires authentication to view an invoice', function () {
    $order = Order::factory()->create();

    $this->get(route('invoices.show', $order))->assertRedirect('/');
});

it('redirects users without a client to setup before viewing invoices', function () {
    $user = \App\Models\User::factory()->create();
    $order = Order::factory()->create();

    $this->actingAs($user)
        ->get(route('invoices.show', $order))
        ->assertRedirect('/setup');
});

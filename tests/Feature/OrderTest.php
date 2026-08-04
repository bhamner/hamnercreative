<?php

use App\Models\Order;

beforeEach(function () {
    $this->user = createUserWithClient();
    $this->client = $this->user->clients()->first();
    $this->order = Order::factory()->create([
        'client_id' => $this->client->id,
    ]);
    $this->withoutVite();
});

it('allows authenticated user to view invoices page', function () {
    $this->actingAs($this->user)
        ->get(route('invoices.index', $this->client))
        ->assertOk()
        ->assertSee($this->client->name.' — Invoices');
});

it('redirects legacy orders url to client invoices', function () {
    $this->actingAs($this->user)
        ->get('/orders')
        ->assertRedirect(route('invoices.index', $this->client));
});

it('defaults invoices date filter to all time', function () {
    $response = $this->actingAs($this->user)
        ->get(route('invoices.index', $this->client))
        ->assertOk();

    expect($response->viewData('dates')['selected'])->toBe('all time');
});

it('forbids non-admin user from viewing order edit page', function () {
    $this->actingAs($this->user)->get(route('orders.edit'))->assertForbidden();
});

it('allows admin user to view order edit page', function () {
    $admin = createAdminUserWithClient();

    $this->actingAs($admin)->get(route('orders.edit'))->assertOk();
});

it('forbids viewing invoice for another clients order', function () {
    $otherOrder = Order::factory()->create();

    $this->actingAs($this->user)->get(route('invoices.show', $otherOrder))->assertForbidden();
});

it('allows viewing invoice for own client order', function () {
    $this->actingAs($this->user)->get(route('invoices.show', $this->order))->assertOk();
});

it('allows admin to update order date', function () {
    $admin = createAdminUserWithClient();
    $client = $admin->clients()->first();
    $order = Order::factory()->create(['client_id' => $client->id]);

    $this->actingAs($admin)
        ->post(route('orders.store'), [
            'order_id' => $order->id,
            'order_title' => 'Updated order',
            'order_client' => $client->id,
            'order_status' => 'open',
            'order_date' => '2020-06-15',
            'service_name' => ['Consulting'],
            'service_rate' => ['100'],
            'service_quantity' => ['1'],
        ])
        ->assertRedirect(route('invoices.index', $client));

    $order->refresh();

    expect($order->name)->toBe('Updated order');
    expect($order->created_at->format('Y-m-d'))->toBe('2020-06-15');
});

<?php

use App\Models\Order;
use App\Models\Service;

beforeEach(function () {
    $this->withoutVite();
});

it('allows an admin to create an order with services', function () {
    $admin = createAdminUserWithClient();
    $client = $admin->clients()->first();

    $this->actingAs($admin)
        ->post(route('orders.store'), [
            'order_title' => 'Brand Package',
            'order_client' => $client->id,
            'order_status' => 'open',
            'order_date' => '2024-01-15',
            'service_name' => ['Design', 'Dev'],
            'service_rate' => ['150', '200'],
            'service_quantity' => ['2', '1'],
        ])
        ->assertRedirect(route('invoices.index', $client));

    $order = Order::query()->where('name', 'Brand Package')->first();

    expect($order)->not->toBeNull()
        ->and($order->status)->toBe('open')
        ->and($order->services)->toHaveCount(2)
        ->and($order->created_at->format('Y-m-d'))->toBe('2024-01-15');
});

it('forbids non-admins from creating orders', function () {
    $user = createUserWithClient();
    $client = $user->clients()->first();

    $this->actingAs($user)
        ->post(route('orders.store'), [
            'order_title' => 'Blocked',
            'order_client' => $client->id,
            'order_status' => 'open',
            'order_date' => now()->toDateString(),
        ])
        ->assertForbidden();
});

it('allows an admin to clone an order and its services', function () {
    $admin = createAdminUserWithClient();
    $client = $admin->clients()->first();
    $order = Order::factory()->create([
        'client_id' => $client->id,
        'status' => 'paid',
        'name' => 'Original',
    ]);
    Service::factory()->create([
        'order_id' => $order->id,
        'name' => 'Consulting',
        'details' => 'Hourly consulting',
        'rate' => 100,
        'quantity' => 1,
    ]);

    $this->actingAs($admin)
        ->from(route('invoices.index', $client))
        ->post(route('orders.clone', $order))
        ->assertRedirect(route('invoices.index', $client))
        ->assertSessionHas('success');

    $clone = Order::query()->where('id', '!=', $order->id)->where('client_id', $client->id)->latest('id')->first();

    expect($clone->status)->toBe('open')
        ->and($clone->services)->toHaveCount(1)
        ->and($clone->services->first()->name)->toBe('Consulting');
});

it('allows an admin to mark an order as paid', function () {
    $admin = createAdminUserWithClient();
    $client = $admin->clients()->first();
    $order = Order::factory()->create([
        'client_id' => $client->id,
        'status' => 'open',
    ]);

    $this->actingAs($admin)
        ->from(route('invoices.index', $client))
        ->post(route('orders.pay', $order))
        ->assertRedirect(route('invoices.index', $client));

    expect($order->fresh()->status)->toBe('paid');
});

it('forbids non-admins from marking orders paid', function () {
    $user = createUserWithClient();
    $order = Order::factory()->create([
        'client_id' => $user->clients()->first()->id,
        'status' => 'open',
    ]);

    $this->actingAs($user)
        ->post(route('orders.pay', $order))
        ->assertForbidden();
});

it('allows an admin to delete an order and its services', function () {
    $admin = createAdminUserWithClient();
    $client = $admin->clients()->first();
    $order = Order::factory()->create([
        'client_id' => $client->id,
    ]);
    Service::factory()->create(['order_id' => $order->id]);

    $this->actingAs($admin)
        ->from(route('invoices.index', $client))
        ->post(route('orders.delete', $order))
        ->assertRedirect(route('invoices.index', $client));

    expect(Order::query()->find($order->id))->toBeNull()
        ->and(Service::query()->where('order_id', $order->id)->count())->toBe(0);
});

it('forbids admins from updating orders for clients they do not belong to', function () {
    $admin = createAdminUserWithClient();
    $foreignOrder = Order::factory()->create();

    $this->actingAs($admin)
        ->get(route('orders.edit', $foreignOrder))
        ->assertForbidden();
});

it('validates required fields when storing an order', function () {
    $admin = createAdminUserWithClient();

    $this->actingAs($admin)
        ->post(route('orders.store'), [])
        ->assertSessionHasErrors(['order_title', 'order_client', 'order_status', 'order_date']);
});

it('lists only orders belonging to the authenticated users clients', function () {
    $user = createUserWithClient();
    $client = $user->clients()->first();
    Order::factory()->create([
        'client_id' => $client->id,
        'name' => 'Own Order',
    ]);
    Order::factory()->create(['name' => 'Foreign Order']);

    $this->actingAs($user)
        ->get(route('invoices.index', $client))
        ->assertOk()
        ->assertSee('Own Order')
        ->assertDontSee('Foreign Order');
});

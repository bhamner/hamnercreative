<?php

use App\Models\Client;
use App\Models\Lead;

beforeEach(function () {
    $this->withoutVite();
});

it('allows a user to view leads for an owned client', function () {
    $user = createUserWithClient();
    $client = $user->clients()->first();
    Lead::factory()->create([
        'client_id' => $client->id,
        'name' => 'Jane Lead',
    ]);

    $this->actingAs($user)
        ->get(route('leads.index', $client))
        ->assertOk()
        ->assertSee('Jane Lead')
        ->assertSee($client->name.' — Leads');
});

it('forbids leads index for a client the user does not belong to', function () {
    $user = createUserWithClients(2);
    $foreign = Client::factory()->create();

    $this->actingAs($user)
        ->get(route('leads.index', $foreign))
        ->assertForbidden();
});

it('shows leads for the selected client', function () {
    $user = createUserWithClients(2);
    $client = $user->clients()->first();
    Lead::factory()->create([
        'client_id' => $client->id,
        'name' => 'Selected Client Lead',
    ]);

    $this->actingAs($user)
        ->get(route('leads.index', $client))
        ->assertOk()
        ->assertSee('Selected Client Lead');
});

it('defaults leads date filter to last 2 years', function () {
    $user = createUserWithClient();
    $client = $user->clients()->first();

    $response = $this->actingAs($user)
        ->get(route('leads.index', $client))
        ->assertOk();

    expect($response->viewData('dates')['selected'])->toBe('last 2 years');
});

it('requires authentication to view leads', function () {
    $client = Client::factory()->create();

    $this->get(route('leads.index', $client))->assertRedirect('/');
});

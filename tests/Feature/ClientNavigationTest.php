<?php

use App\Models\Client;

beforeEach(function () {
    mockAnalytics();
    $this->withoutVite();
});

it('lists every attached client in the sidenav', function () {
    $user = createUserWithClients(2);
    $clients = $user->clients;

    $this->actingAs($user)
        ->get(route('metrics.show', $clients->first()))
        ->assertOk()
        ->assertSee($clients[0]->name, false)
        ->assertSee($clients[1]->name, false)
        ->assertSee('Metrics')
        ->assertSee('Invoices');
});

it('only shows content and leads links when client flags are enabled', function () {
    $user = createUserWithClient();
    $client = $user->clients()->first();
    $client->forceFill([
        'has_content' => 1,
        'has_leads' => 0,
        'name' => 'Flag Client',
    ])->save();

    $this->actingAs($user)
        ->get(route('metrics.show', $client->fresh()))
        ->assertOk()
        ->assertSee('Site content')
        ->assertSee(route('content.index', $client), false)
        ->assertDontSee(route('leads.index', $client), false);
});

it('requires a client in the path for list pages', function () {
    $user = createUserWithClient();
    $client = $user->clients()->first();

    $this->actingAs($user)
        ->get('/dashboard')
        ->assertRedirect(route('metrics.show', $client));

    $this->actingAs($user)
        ->get('/orders')
        ->assertRedirect(route('invoices.index', $client));

    $this->actingAs($user)
        ->get('/content')
        ->assertRedirect(route('content.index', $client));

    $this->actingAs($user)
        ->get('/leads')
        ->assertRedirect(route('leads.index', $client));
});

it('honors ?client= on legacy redirects', function () {
    $user = createUserWithClients(2);
    $second = $user->clients()->skip(1)->first();

    $this->actingAs($user)
        ->get('/dashboard?client='.$second->id)
        ->assertRedirect(route('metrics.show', $second));
});

it('shows the date filter in the top nav without a client selector', function () {
    $user = createUserWithClients(2);
    $client = $user->clients()->first();

    $this->actingAs($user)
        ->get(route('invoices.index', $client))
        ->assertOk()
        ->assertDontSee('id="client_filter"', false)
        ->assertSee('id="date_filter"', false)
        ->assertSee('app-header-date-filter', false);
});

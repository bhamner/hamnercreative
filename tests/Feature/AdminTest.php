<?php

beforeEach(function () {
    mockAnalytics();
    $this->user = createUserWithClient();
    $this->client = $this->user->clients()->first();
    $this->actingAs($this->user);
    $this->withoutVite();
});

it('allows authenticated user to view metrics', function () {
    $this->get(route('metrics.show', $this->client))->assertOk()
        ->assertSee($this->client->name.' — Metrics');
});

it('redirects legacy dashboard to client metrics', function () {
    $this->get('/dashboard')
        ->assertRedirect(route('metrics.show', $this->client));
});

it('defaults metrics date filter to this month', function () {
    $response = $this->get(route('metrics.show', $this->client))->assertOk();

    expect($response->viewData('dates')['selected'])->toBe('this month');
});

it('applies an approved date filter on metrics', function () {
    $this->get(route('metrics.show', $this->client).'?date=this%20year')->assertOk();
});

it('forbids metrics for a client the user does not belong to', function () {
    $foreign = \App\Models\Client::factory()->create();

    $this->get(route('metrics.show', $foreign))->assertForbidden();
});

it('requires authentication for metrics', function () {
    auth()->logout();

    $this->get(route('metrics.show', $this->client))->assertRedirect('/');
});

<?php

use App\Models\User;

beforeEach(function () {
    $this->withoutVite();
});

it('redirects login attempt to the SSO provider', function () {
    $this->get('/auth/google')->assertRedirect();
});

it('allows authenticated user to view metrics', function () {
    mockAnalytics();
    $user = createUserWithClient();
    $client = $user->clients()->first();

    $this->actingAs($user)->get(route('metrics.show', $client))->assertOk();
});

it('redirects unauthenticated user away from metrics', function () {
    $client = \App\Models\Client::factory()->create();

    $this->get(route('metrics.show', $client))->assertRedirect('/');
});

it('rejects oauth callback without a valid state parameter', function () {
    $this->withoutExceptionHandling();

    $this->get('/auth/callback');
})->throws(\Laravel\Socialite\Two\InvalidStateException::class);

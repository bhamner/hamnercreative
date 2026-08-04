<?php

use App\Models\Client;
use App\Models\User;
use Illuminate\Support\Facades\RateLimiter;

beforeEach(function () {
    $this->withoutVite();
});

it('shows the setup gate for authenticated users without clients', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get('/setup')
        ->assertOk();
});

it('redirects users who already have a client away from setup', function () {
    $user = createUserWithClient();
    $client = $user->clients()->first();

    $this->actingAs($user)
        ->get('/setup')
        ->assertRedirect(route('metrics.show', $client));
});

it('attaches a client when a valid access code is submitted', function () {
    $user = User::factory()->create();
    $client = Client::factory()->create(['access_code' => 'abcdefghijklmn']);

    $this->actingAs($user)
        ->post('/validate', ['client_code' => 'abcdefghijklmn'])
        ->assertRedirect(route('metrics.show', $client));

    expect($user->fresh()->clients()->pluck('id'))->toContain($client->id);
});

it('rejects invalid client access codes', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post('/validate', ['client_code' => 'not-a-valid-cd'])
        ->assertSessionHasErrors('client_code');
});

it('rate limits setup code validation attempts', function () {
    $user = User::factory()->create();
    $client = Client::factory()->create(['access_code' => 'abcdefghijklmn']);
    $key = 'client-setup:'.$user->id;

    RateLimiter::clear($key);

    for ($i = 0; $i < 5; $i++) {
        RateLimiter::hit($key);
    }

    $this->actingAs($user)
        ->from('/setup')
        ->post('/validate', ['client_code' => $client->access_code])
        ->assertRedirect('/setup')
        ->assertSessionHasErrors('client_code');
});

it('blocks pending users from the dashboard until setup is complete', function () {
    mockAnalytics();
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get('/dashboard')
        ->assertRedirect('/setup');
});

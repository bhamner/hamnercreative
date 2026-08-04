<?php

use App\Models\Client;
use App\Services\ClientResolver;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;

uses(RefreshDatabase::class);

it('returns the only client for single-client users without a route client', function () {
    $user = createUserWithClient();

    $client = app(ClientResolver::class)->resolve(
        $user,
        Request::create('/order/edit', 'GET'),
        $user->clients
    );

    expect($client->id)->toBe($user->clients()->first()->id);
});

it('returns null for multi-client users without a route client', function () {
    $user = createUserWithClients(2);

    $client = app(ClientResolver::class)->resolve(
        $user,
        Request::create('/order/edit', 'GET'),
        $user->clients
    );

    expect($client)->toBeNull();
});

it('returns the route client when the user belongs to it', function () {
    $user = createUserWithClients(2);
    $selected = $user->clients()->first();

    $client = app(ClientResolver::class)->resolve(
        $user,
        requestWithRouteClient($selected),
        $user->clients
    );

    expect($client->id)->toBe($selected->id);
});

it('ignores route clients the user does not belong to', function () {
    $user = createUserWithClients(2);
    $foreign = Client::factory()->create();

    $client = app(ClientResolver::class)->resolve(
        $user,
        requestWithRouteClient($foreign),
        $user->clients
    );

    expect($client)->toBeNull();
});

function requestWithRouteClient(Client $client): Request
{
    $request = Request::create('/clients/'.$client->id.'/metrics', 'GET');
    $route = new Route('GET', '/clients/{client}/metrics', fn () => null);
    $route->bind($request);
    $route->setParameter('client', $client);
    $request->setRouteResolver(fn () => $route);

    return $request;
}

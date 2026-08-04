<?php

use App\Models\Client;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Analytics\Facades\Analytics;

uses(Tests\TestCase::class)->in('Unit');

uses(
    Tests\TestCase::class,
    RefreshDatabase::class,
)->in('Feature');

function createUserWithClient(array $userAttributes = []): User
{
    $user = User::factory()->create($userAttributes);
    $client = Client::factory()->create();
    $user->clients()->attach($client);

    return $user->fresh();
}

function createAdminUserWithClient(): User
{
    return createUserWithClient(['is_admin' => true]);
}

function createUserWithClients(int $count = 2, array $userAttributes = []): User
{
    $user = User::factory()->create($userAttributes);
    $clients = Client::factory()->count($count)->create();
    $user->clients()->attach($clients->pluck('id'));

    return $user->fresh();
}

function mockAnalytics(): void
{
    Analytics::shouldReceive('get')->andReturn(collect());
}

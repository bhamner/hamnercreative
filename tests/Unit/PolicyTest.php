<?php

use App\Models\Client;
use App\Models\Content;
use App\Models\Order;
use App\Models\User;
use App\Policies\ClientPolicy;
use App\Policies\ContentPolicy;
use App\Policies\OrderPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('allows users to view only their own account', function () {
    $user = User::factory()->create();
    $other = User::factory()->create();
    $policy = new UserPolicy;

    expect($policy->view($user, $user))->toBeTrue()
        ->and($policy->view($user, $other))->toBeFalse()
        ->and($policy->delete($user, $user))->toBeTrue()
        ->and($policy->delete($user, $other))->toBeFalse();
});

it('scopes client access to membership', function () {
    $user = createUserWithClient();
    $otherClient = Client::factory()->create();
    $policy = new ClientPolicy;

    expect($policy->view($user, $user->clients()->first()))->toBeTrue()
        ->and($policy->view($user, $otherClient))->toBeFalse();
});

it('scopes content permissions to client membership', function () {
    $user = createUserWithClient();
    $ownContent = Content::factory()->create([
        'client_id' => $user->clients()->first()->id,
    ]);
    $otherContent = Content::factory()->create();
    $policy = new ContentPolicy;

    expect($policy->view($user, $ownContent))->toBeTrue()
        ->and($policy->update($user, $ownContent))->toBeTrue()
        ->and($policy->delete($user, $ownContent))->toBeTrue()
        ->and($policy->create($user, $user->clients()->first()))->toBeTrue()
        ->and($policy->view($user, $otherContent))->toBeFalse()
        ->and($policy->update($user, $otherContent))->toBeFalse();
});

it('requires admin for order mutations', function () {
    $member = createUserWithClient();
    $admin = createAdminUserWithClient();
    $memberOrder = Order::factory()->create([
        'client_id' => $member->clients()->first()->id,
    ]);
    $adminOrder = Order::factory()->create([
        'client_id' => $admin->clients()->first()->id,
    ]);
    $policy = new OrderPolicy;

    expect($policy->viewAny($member))->toBeTrue()
        ->and($policy->view($member, $memberOrder))->toBeTrue()
        ->and($policy->create($member))->toBeFalse()
        ->and($policy->update($member, $memberOrder))->toBeFalse()
        ->and($policy->delete($member, $memberOrder))->toBeFalse()
        ->and($policy->create($admin))->toBeTrue()
        ->and($policy->update($admin, $adminOrder))->toBeTrue()
        ->and($policy->delete($admin, $adminOrder))->toBeTrue()
        ->and($policy->update($admin, $memberOrder))->toBeFalse();
});

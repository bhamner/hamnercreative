<?php

use App\Models\User;
use Illuminate\Support\Facades\DB;

beforeEach(function () {
    $this->withoutVite();
});

it('allows an authenticated user to view their account page', function () {
    $user = createUserWithClient();

    $this->actingAs($user)
        ->get(route('user.show'))
        ->assertOk()
        ->assertSee($user->email);
});

it('requires authentication to view the account page', function () {
    $this->get(route('user.show'))->assertRedirect('/');
});

it('soft deletes the account and detaches clients with a valid confirmation code', function () {
    $user = createUserWithClient(['vendor_id' => '12345678901234567890']);
    $clientId = $user->clients()->first()->id;

    $this->actingAs($user)
        ->post(route('user.delete'), [
            'deleteConfirmationCode' => '12345',
        ])
        ->assertRedirect('/');

    $this->assertGuest();
    expect(User::withTrashed()->find($user->id)->trashed())->toBeTrue()
        ->and($user->clients()->count())->toBe(0)
        ->and(DB::table('client_user')->where('client_id', $clientId)->where('user_id', $user->id)->exists())->toBeFalse();
});

it('rejects account deletion with an invalid confirmation code', function () {
    $user = createUserWithClient(['vendor_id' => '12345678901234567890']);

    $this->actingAs($user)
        ->from(route('user.show'))
        ->post(route('user.delete'), [
            'deleteConfirmationCode' => '00000',
        ])
        ->assertSessionHasErrors('deleteConfirmationCode');

    expect($user->fresh()->trashed())->toBeFalse();
});

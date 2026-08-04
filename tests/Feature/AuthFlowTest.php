<?php

use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as SocialiteUser;

beforeEach(function () {
    $this->withoutVite();
});

it('logs a user out and clears the session', function () {
    $user = createUserWithClient();

    $this->actingAs($user)
        ->post(route('logout'))
        ->assertRedirect('/');

    $this->assertGuest();
});

it('creates a user from a google oauth response', function () {
    mockGoogleUser([
        'id' => '999888777',
        'name' => 'New User',
        'email' => 'new@example.com',
        'avatar' => 'https://example.com/avatar.jpg',
    ]);

    $this->get('/auth/callback')->assertRedirect(route('dashboard'));

    $this->assertAuthenticated();
    expect(User::query()->where('vendor_id', '999888777')->first())
        ->name->toBe('New User')
        ->email->toBe('new@example.com');
});

it('restores a soft deleted user on google login', function () {
    $user = User::factory()->create([
        'vendor_id' => '555444333',
        'name' => 'Old Name',
        'email' => 'old@example.com',
    ]);
    $user->delete();

    mockGoogleUser([
        'id' => '555444333',
        'name' => 'Restored Name',
        'email' => 'restored@example.com',
        'avatar' => 'https://example.com/a.jpg',
    ]);

    $this->get('/auth/callback')->assertRedirect(route('dashboard'));

    expect($user->fresh())
        ->trashed()->toBeFalse()
        ->name->toBe('Restored Name')
        ->email->toBe('restored@example.com');
});

it('serves public legal pages', function (string $path) {
    $this->get($path)->assertOk();
})->with([
    '/privacy',
    '/terms',
    '/cookies',
]);

function mockGoogleUser(array $attributes): void
{
    $socialiteUser = new SocialiteUser;
    $socialiteUser->id = $attributes['id'];
    $socialiteUser->name = $attributes['name'];
    $socialiteUser->email = $attributes['email'];
    $socialiteUser->avatar = $attributes['avatar'];

    $provider = Mockery::mock(\Laravel\Socialite\Contracts\Provider::class);
    $provider->shouldReceive('user')->andReturn($socialiteUser);

    Socialite::shouldReceive('driver')->with('google')->andReturn($provider);
}

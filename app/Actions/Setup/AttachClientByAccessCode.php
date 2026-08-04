<?php

namespace App\Actions\Setup;

use App\Models\Client;
use App\Models\User;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class AttachClientByAccessCode
{
    public function __invoke(User $user, string $accessCode): Client
    {
        $key = 'client-setup:'.$user->id;

        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);

            throw ValidationException::withMessages([
                'client_code' => 'Too many attempts! You may try again in '.$seconds.' seconds.',
            ]);
        }

        RateLimiter::hit($key);

        $client = Client::query()
            ->where('access_code', $accessCode)
            ->firstOrFail();

        $user->clients()->syncWithoutDetaching([$client->id]);

        return $client;
    }
}

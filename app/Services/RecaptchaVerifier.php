<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;

class RecaptchaVerifier
{
    public function assertValid(string $token, float $minScore = 0.6): void
    {
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => config('services.recaptcha_v3.secretKey'),
            'response' => $token,
            'remoteip' => request()->ip(),
        ]);

        $fail = fn (string $message) => throw ValidationException::withMessages([
            'recaptcha' => $message,
        ]);

        if (! $response->successful() || ! $response->json('success')) {
            $fail($response->json('error-codes.0') ?? 'An error occurred.');
        }

        if ($response->json('score') < $minScore) {
            $fail('We were unable to verify that you\'re not a robot. Please try again.');
        }
    }
}

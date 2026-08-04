<?php

namespace App\Http\Controllers;

use App\Actions\Auth\SyncSocialiteUser;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware(['guest', 'throttle:60,1'], ['except' => 'logout']);
    }

    public function redirectToProvider(): RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleProviderResponse(SyncSocialiteUser $syncSocialiteUser): RedirectResponse
    {
        $socialiteUser = Socialite::driver('google')->user();
        $user = $syncSocialiteUser($socialiteUser);

        Auth::login($user, true);
        request()->session()->regenerate();

        return redirect()->intended(route('dashboard'));
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('welcome');
    }
}

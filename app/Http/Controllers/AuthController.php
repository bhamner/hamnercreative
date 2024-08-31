<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class AuthController extends Controller
{

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';


    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware(['guest','throttle:60,1'], ['except' => 'logout']);
    }


    /**
     * Redirect to SSO provider
     *
     */
    public function redirectToProvider(): RedirectResponse 
    {
        return Socialite::driver('google')->redirect();
    }


    /**
     * Handle authenticated users
     * 
     */
    protected function authenticated(Request $request, $user): RedirectResponse
    {
        return redirect()->intended($this->redirectTo);
    }


    /**
     * Handle an authentication attempt.
     */
    public function handleProviderResponse(Request $request): RedirectResponse
    {
        $vendor_response = Socialite::driver('google')->stateless()->user();
        
        $user = $this->syncUserObject($vendor_response);

        if ($user && Auth::login($user, $remember = true)) {
            $request->session()->regenerate();
            return redirect()->intended($this->redirectTo);
        }
 
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }


    /**
     * sync database with vendor response
     */
    protected function syncUserObject($vendor_response): \App\Models\User
    {

        $previous_account = \App\Models\User::withTrashed()
            ->where('vendor_id',$vendor_response->id)
            ->first();

        if( $previous_account ){
           $previous_account->update([
                'name' => $vendor_response->name, 
                'email' => $vendor_response->email, 
                'avatar' => $vendor_response->avatar,
                'deleted_at' => null,
            ]);
           return $previous_account;
        }

        $user = \App\Models\User::updateOrCreate([
            'vendor_id' => $vendor_response->id
        ],[
            'name' => $vendor_response->name, 
            'email' => $vendor_response->email, 
            'avatar' => $vendor_response->avatar 
        ]);
        return $user;
    }


    /**
     * Logout user
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        return  redirect('/');
    }

}
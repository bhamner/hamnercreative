<?php

namespace App\Http\Controllers;

use Auth;
use RateLimiter;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;


class SetupController extends Controller
{

    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show gate for code entry
     *
     */
    public function gate(): mixed
    {
        if( Auth::user()->clients()->count() > 0 ){ 
            return redirect('/dashboard'); 
        }
        return view('setup.gate');
    }

    /**
     * Validate code entry and setup client
     *
     */
    public function validateCode( Request $request ): RedirectResponse 
    {
        if (RateLimiter::tooManyAttempts('send-message:'.Auth::user()->id, $perMinute = 5)) {
            $seconds = RateLimiter::availableIn('send-message:'.Auth::user()->id);
            return back()->withErrors('Too many attempts! You may try again in '.$seconds.' seconds.');
        }
        RateLimiter::increment('send-message:'.Auth::user()->id);
        $validated = $request->validate([
            'client_code' => 'required|size:14|exists:\App\Models\Client,access_code',
         ]);

        $client = \App\Models\Client::where('access_code',$request->get('client_code'))->first();
        Auth::user()->clients()->attach($client->id);

        return redirect('/dashboard');
    }
}

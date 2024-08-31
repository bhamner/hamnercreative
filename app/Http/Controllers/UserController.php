<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class UserController extends Controller
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
     * Show user account
     *
     */
    public function show(\App\Models\User $user): View 
    {
        return view('user.show',compact('user'));
    }


    /**
     * Delete user account
     *
     */
    public function delete(\App\Models\User $user, Request $request): RedirectResponse
    {
        $confirmation_code = substr(Auth::user()->vendor_id, 0, 5);

        $validated = $request->validate([
            'deleteConfirmationCode' => 'required|in:'.$confirmation_code.'|numeric',
        ]);

        $user->clients()->detach();
        $user->delete();
        Auth::logout();
        $request->session()->invalidate();
        return  redirect('/');
    }


}
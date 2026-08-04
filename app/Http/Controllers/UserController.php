<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteUserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show(): View
    {
        /** @var User $user */
        $user = Auth::user();
        $this->authorize('view', $user);

        return view('user.show', compact('user'));
    }

    public function delete(DeleteUserRequest $request): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();
        $this->authorize('delete', $user);

        $user->clients()->detach();
        $user->delete();

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('welcome');
    }
}

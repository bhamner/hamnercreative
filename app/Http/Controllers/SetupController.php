<?php

namespace App\Http\Controllers;

use App\Actions\Setup\AttachClientByAccessCode;
use App\Http\Requests\ValidateClientCodeRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SetupController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function gate(): View|RedirectResponse
    {
        /** @var User $user */
        $user = auth()->user();

        if ($user->clients()->exists()) {
            return redirect()->route('metrics.show', $user->clients()->first());
        }

        return view('setup.gate');
    }

    public function validateCode(
        ValidateClientCodeRequest $request,
        AttachClientByAccessCode $attachClient
    ): RedirectResponse {
        /** @var User $user */
        $user = $request->user();

        $client = $attachClient($user, $request->validated('client_code'));

        return redirect()->route('metrics.show', $client ?? $user->clients()->first());
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ClientHomeRedirectController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'block.pending']);
    }

    public function metrics(Request $request): RedirectResponse
    {
        return $this->redirectTo($request, 'metrics.show');
    }

    public function invoices(Request $request): RedirectResponse
    {
        return $this->redirectTo($request, 'invoices.index');
    }

    public function content(Request $request): RedirectResponse
    {
        return $this->redirectTo($request, 'content.index');
    }

    public function leads(Request $request): RedirectResponse
    {
        return $this->redirectTo($request, 'leads.index');
    }

    protected function redirectTo(Request $request, string $route): RedirectResponse
    {
        /** @var User $user */
        $user = $request->user();

        $clientId = $request->query('client');
        $client = null;

        if ($clientId) {
            $client = $user->clients()->where('clients.id', $clientId)->first();
        }

        $client ??= $user->clients()->first();

        if (! $client instanceof Client) {
            return redirect('/setup');
        }

        $params = ['client' => $client];

        if ($request->filled('date')) {
            $params['date'] = $request->query('date');
        }

        return redirect()->route($route, $params);
    }
}

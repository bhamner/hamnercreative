<?php

namespace App\Http\Middleware;

use App\Services\ClientResolver;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class ClientFilter
{
    public function __construct(private ClientResolver $clientResolver)
    {
    }

    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        $clients = $user->clients;
        $client = $this->clientResolver->resolve($user, $request, $clients);

        $request->merge(compact('clients', 'client'));
        View::share(compact('clients', 'client'));

        return $next($request);
    }
}

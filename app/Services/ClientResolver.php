<?php

namespace App\Services;

use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class ClientResolver
{
    /**
     * @param  Collection<int, Client>  $clients
     */
    public function resolve(User $user, Request $request, Collection $clients): ?Client
    {
        $routeClient = $request->route('client');

        if ($routeClient instanceof Client) {
            return $clients->firstWhere('id', $routeClient->id);
        }

        if (is_numeric($routeClient)) {
            return $clients->firstWhere('id', (int) $routeClient);
        }

        if ($clients->count() === 1) {
            return $clients->first();
        }

        return null;
    }
}

<?php

namespace App\Policies\Concerns;

use App\Models\Client;
use App\Models\User;

trait InteractsWithClientAccess
{
    protected function belongsToClient(User $user, Client|int|null $client): bool
    {
        if ($client === null) {
            return false;
        }

        $clientId = $client instanceof Client ? $client->id : $client;

        return $user->clients()->whereKey($clientId)->exists();
    }
}

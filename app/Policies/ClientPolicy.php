<?php

namespace App\Policies;

use App\Models\Client;
use App\Models\User;
use App\Policies\Concerns\InteractsWithClientAccess;

class ClientPolicy
{
    use InteractsWithClientAccess;

    public function view(User $user, Client $client): bool
    {
        return $this->belongsToClient($user, $client);
    }
}

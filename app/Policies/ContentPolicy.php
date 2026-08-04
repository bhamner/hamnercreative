<?php

namespace App\Policies;

use App\Models\Client;
use App\Models\Content;
use App\Models\User;
use App\Policies\Concerns\InteractsWithClientAccess;

class ContentPolicy
{
    use InteractsWithClientAccess;

    public function view(User $user, Content $content): bool
    {
        return $this->belongsToClient($user, $content->client_id);
    }

    public function create(User $user, Client $client): bool
    {
        return $this->belongsToClient($user, $client);
    }

    public function update(User $user, Content $content): bool
    {
        return $this->belongsToClient($user, $content->client_id);
    }

    public function delete(User $user, Content $content): bool
    {
        return $this->update($user, $content);
    }
}

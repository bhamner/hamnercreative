<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;
use App\Policies\Concerns\InteractsWithClientAccess;

class OrderPolicy
{
    use InteractsWithClientAccess;

    public function viewAny(User $user): bool
    {
        return $user->clients()->exists();
    }

    public function view(User $user, Order $order): bool
    {
        return $this->belongsToClient($user, $order->client_id);
    }

    public function create(User $user): bool
    {
        return $user->is_admin;
    }

    public function update(User $user, Order $order): bool
    {
        return $user->is_admin && $this->belongsToClient($user, $order->client_id);
    }

    public function delete(User $user, Order $order): bool
    {
        return $this->update($user, $order);
    }
}

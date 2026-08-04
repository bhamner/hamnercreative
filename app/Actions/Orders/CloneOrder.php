<?php

namespace App\Actions\Orders;

use App\Models\Order;

class CloneOrder
{
    public function __invoke(Order $order): Order
    {
        $order->loadMissing('services');

        $clone = $order->replicate();
        $clone->status = 'open';
        $clone->save();

        foreach ($order->services as $service) {
            $clone->services()->save($service->replicate());
        }

        return $clone->fresh(['services']);
    }
}

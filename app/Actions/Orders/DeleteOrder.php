<?php

namespace App\Actions\Orders;

use App\Models\Order;

class DeleteOrder
{
    public function __invoke(Order $order): void
    {
        $order->services()->delete();
        $order->delete();
    }
}

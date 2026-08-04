<?php

namespace App\Actions\Orders;

use App\Models\Order;

class MarkOrderPaid
{
    public function __invoke(Order $order): Order
    {
        $order->status = 'paid';
        $order->save();

        return $order;
    }
}

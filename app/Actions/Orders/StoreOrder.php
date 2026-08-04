<?php

namespace App\Actions\Orders;

use App\Models\Client;
use App\Models\Order;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class StoreOrder
{
    /**
     * @param  array{
     *     order_title: string,
     *     order_client: int|string,
     *     order_status: string,
     *     order_date: string,
     *     order_id?: int|string|null,
     *     service_name?: array<int, string|null>,
     *     service_rate?: array<int, string|null>,
     *     service_quantity?: array<int, string|null>
     * }  $data
     */
    public function __invoke(array $data, Client $client, ?Order $order = null): Order
    {
        $order ??= new Order;
        $order->client_id = $client->id;
        $order->name = $data['order_title'];
        $order->status = $data['order_status'];
        $order->created_at = Carbon::parse($data['order_date'])->startOfDay();
        $order->save();

        $services = $this->buildServices(collect([
            'service_name' => $data['service_name'] ?? [],
            'service_rate' => $data['service_rate'] ?? [],
            'service_quantity' => $data['service_quantity'] ?? [],
        ]));

        $order->services()->delete();
        $order->services()->saveMany($services);

        return $order->fresh(['services']);
    }

    /**
     * @return Collection<int, Service>
     */
    protected function buildServices(Collection $input): Collection
    {
        return $input->transpose()->map(function (array $serviceData) {
            return new Service([
                'name' => $serviceData['service_name'],
                'rate' => $serviceData['service_rate'],
                'quantity' => $serviceData['service_quantity'],
                'details' => '',
            ]);
        });
    }
}

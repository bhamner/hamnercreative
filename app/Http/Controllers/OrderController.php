<?php

namespace App\Http\Controllers;

use App\Actions\Orders\CloneOrder;
use App\Actions\Orders\DeleteOrder;
use App\Actions\Orders\MarkOrderPaid;
use App\Actions\Orders\StoreOrder;
use App\Http\Requests\StoreOrderRequest;
use App\Models\Client;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'block.pending', 'filter.date', 'filter.client']);
    }

    public function index(Request $request, Client $client): View
    {
        $this->authorize('view', $client);
        $this->authorize('viewAny', Order::class);

        $orders = Order::query()
            ->whereBetween('created_at', $request->dates['params'])
            ->where('client_id', $client->id)
            ->get();

        return view('orders.index', compact('orders', 'client'));
    }

    public function edit(?Order $order = null): View
    {
        if ($order) {
            $this->authorize('update', $order);
        } else {
            $this->authorize('create', Order::class);
        }

        return view('orders.edit', compact('order'));
    }

    public function store(StoreOrderRequest $request, StoreOrder $storeOrder): RedirectResponse
    {
        $this->authorize('create', Order::class);

        $client = Client::query()->findOrFail($request->validated('order_client'));
        $this->authorize('view', $client);

        $order = null;
        if ($request->filled('order_id')) {
            $order = Order::query()->findOrFail($request->validated('order_id'));
            $this->authorize('update', $order);
        }

        $storeOrder($request->validated(), $client, $order);

        return redirect()->route('invoices.index', $client)->with('success', 'Order saved!');
    }

    public function clone(Order $order, CloneOrder $cloneOrder): RedirectResponse
    {
        $this->authorize('update', $order);
        $cloneOrder($order);

        return back()->with('success', 'Order Cloned!');
    }

    public function pay(Order $order, MarkOrderPaid $markOrderPaid): RedirectResponse
    {
        $this->authorize('update', $order);
        $markOrderPaid($order);

        return back()->with('success', 'Payment Updated!');
    }

    public function delete(Order $order, DeleteOrder $deleteOrder): RedirectResponse
    {
        $this->authorize('delete', $order);
        $deleteOrder($order);

        return back()->with('success', 'Order Deleted!');
    }
}

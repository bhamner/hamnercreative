<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;

class OrderController extends Controller
{

    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware(['auth','block.pending','filter.date','filter.client']);
    }


    /**
     * List user's orders
     *
     */
    public function index( Request $request ): View 
    {       
        $gate = Gate::inspect('admin');
        $orders = \App\Models\Order::whereBetween('created_at',$request->dates['params'])
                                ->whereIn('client_id',  Auth::user()->clients()->pluck('id'))
                                ->when($request->client, function($query) use ($request) {
                                    return $query->where('client_id', $request->client->id);
                                })->get();

        return view('orders.index',compact('orders','gate'));
    }


    /**
     * Show a form to create or update an order
     *
     */

    public function edit(\App\Models\Order $order = null): view
    {
        Gate::authorize('admin'); 
        return view('orders.edit',compact('order'));
    }


    /**
     * Clone an existing order with service relations
     *
     */
    public function clone( \App\Models\Order $order ): RedirectResponse
    {
        Gate::authorize('admin'); 
        $new_order = $order->load('services')->replicate();
        $new_order->status = "open";
        $new_order->save();
 
        foreach( $order->services as $service ){
            $new_service = $service->replicate();
            $new_order->services()->save( $new_service );
        }
        
        return back()->with('success', 'Order Cloned!');
    } 


    /**
     * Mark order as paid
     *
     */
    public function pay( \App\Models\Order $order ): RedirectResponse
    {
        Gate::authorize('admin'); 
        $order->status = "paid";
        $order->save();
 
        return back()->with('success', 'Payment Updated!');
    }

    /**
     * Store order and relations in database 
     *
     */
    public function store(Request $request): RedirectResponse
    {
        Gate::authorize('admin'); 
        $validated = $request->validate([
            'order_title' => 'required|max:255',
            'order_id' => 'nullable|numeric|exists:App\Models\Order,id',
            'order_client'=> 'required|numeric|exists:App\Models\Client,id',
            'order_status' => 'required|in:paid,open',
            'service_name.*' => 'max:255',
            'service_rate.*' => 'nullable|numeric',
            'service_quantity.*' => 'nullable|numeric'
        ]);

        $new_order = $request->has('order_id') ? \App\Models\Order::find( $request->get('order_id') ) : new \App\Models\Order();
        $new_order->client_id = $request->get('order_client');
        $new_order->name = $request->get('order_title');
        $new_order->status = $request->get('order_status');
        $new_order->save();

        $requestData = collect($request->only('service_name', 'service_rate', 'service_quantity'));
        $new_services = $requestData->transpose()->map(function ( $serviceData ) {
            return new \App\Models\Service([
                'name' => $serviceData['service_name'],
                'rate' => $serviceData['service_rate'],
                'quantity' => $serviceData['service_quantity'],
            ]);
        });
        $new_order->services()->delete();
        $new_order->services()->saveMany( $new_services );
 
        return redirect('/orders')->with('success', 'Order saved!');
    }


    /**
     * Delete order and services
     *
     */
    public function delete( \App\Models\Order $order ): RedirectResponse
    {
        Gate::authorize('admin'); 
        $order->services()->delete();
        $order->delete();
 
        return back()->with('success', 'Order Deleted!');
    }


}
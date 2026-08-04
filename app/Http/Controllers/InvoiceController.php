<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\View\View;

class InvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'block.pending']);
    }

    public function show(Order $order): View
    {
        $this->authorize('view', $order);

        return view('invoice.show', compact('order'));
    }
}

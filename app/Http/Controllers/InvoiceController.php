<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Illuminate\View\View;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{

    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware(['auth','block.pending']);
    }


    /**
     * Show invoice
     *
     */
    public function show( Request $request, \App\Models\Order $order ): View 
    {       
        return view('invoice.show',compact('order'));
    }


}
<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class LeadsController extends Controller
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
     * Show list of all form generated leads for client
     *
     */
    public function index( Request $request ): View 
    {   
        $gate = Gate::authorize('user_has_client',$request);
        $leads= \App\Models\Lead::whereBetween('updated_at',$request->dates['params'])
                                ->when($request->client, function($query) use ($request) {
                                    return $query->where('client_id', $request->client->id);
                                })->get();

        return view('leads.index',compact('leads'));
    }


}
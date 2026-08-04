<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LeadsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'block.pending', 'filter.date', 'filter.client']);
    }

    public function index(Request $request, Client $client): View
    {
        $this->authorize('view', $client);

        $leads = Lead::query()
            ->whereBetween('updated_at', $request->dates['params'])
            ->where('client_id', $client->id)
            ->get();

        return view('leads.index', compact('leads', 'client'));
    }
}

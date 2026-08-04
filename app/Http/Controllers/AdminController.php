<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Services\AnalyticsDashboardService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'block.pending', 'filter.date', 'filter.client']);
    }

    public function showUserDashboard(Request $request, Client $client, AnalyticsDashboardService $analytics): View
    {
        $this->authorize('view', $client);

        $dashboard = $analytics->forClient($client, $request->dates);

        return view('admin.dashboard', [
            'request' => $request,
            'client' => $client,
            'analytics' => $dashboard,
        ]);
    }
}

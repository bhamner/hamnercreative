<?php

namespace App\Http\Controllers;

use Auth;
use Carbon;
use Spatie\Analytics\Period;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Spatie\Analytics\Facades\Analytics;

class AdminController extends Controller
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
     * Show authenticated user dashboard
     *
     */
    public function showUserDashboard( Request $request ): View 
    {
        //retrieve visitors and page view data for the current date range
        $analyticsData = Analytics::get( 
            $request->dates['period'],
            ['activeUsers','screenPageViews'],
            ['streamId','date' ], 100000
            );
 
        $analytics = \App\Logic\AnalyticsTransformer::getInstance()
            ->setData($analyticsData->whereIn('streamId', Auth::user()->clients()->pluck('ga_stream_id')))
            ->build();
 
        return view( 'admin.dashboard', compact('request','analytics') );
    }

}

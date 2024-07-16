<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\View\View;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Show authenticated user dashboard
     *
     */
    public function showUserDashboard(): View 
    {
        return view('dashboard');
    }

}

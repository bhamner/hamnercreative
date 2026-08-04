<?php

namespace App\Http\Middleware;

use App\Services\DateRangeService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class DateFilter
{
    public function __construct(private DateRangeService $dateRangeService)
    {
    }

    public function handle(Request $request, Closure $next): Response
    {
        $dates = $this->dateRangeService->resolve($request);

        $request->merge(compact('dates'));
        View::share(compact('dates'));

        return $next($request);
    }
}

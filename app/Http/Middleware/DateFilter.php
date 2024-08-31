<?php 
namespace App\Http\Middleware;

use Closure;
use Symfony\Component\HttpFoundation\Response;


class DateFilter{
 
 	/**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
	public function handle($request, Closure $next): Response
	{

        $dates = \App\Logic\DateTransformer::getInstance()->setData($request)->build();

  	   //add to request to share with controller
        $request->merge( compact('dates') );
 
        //share with view
        \View::share( compact('dates') );
		 
	   return $next($request);
	}
 


}

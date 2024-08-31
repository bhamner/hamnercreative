<?php 
namespace App\Http\Middleware;

use Auth;
use Closure;
use Symfony\Component\HttpFoundation\Response;


class ClientFilter{
 
 	/**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
	public function handle($request, Closure $next): Response
	{

        $clients = Auth::user()->clients;
 
        $client = \App\Logic\Helper::getCurrentClient($request,$clients);
 
  	   //add to request to share with controller
        $request->merge( compact('clients','client') );
 
        //share with view
        \View::share( compact('clients','client') );
		 
	    return $next($request);
	}
 


}

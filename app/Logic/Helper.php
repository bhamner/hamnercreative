<?php

namespace App\Logic;

use Auth;

class Helper
{

    /**
     * Return the current client from request or design
     */
	public static function getCurrentClient($request,$clients): ?\App\Models\Client
	{
		if( Auth::user()->clients()->count() == 1 ){ return Auth::user()->clients()->first(); }
		return  $request->has('client') && $request->get('client') && $clients->contains('id',$request->get('client'))  ? $clients->find($request->get('client')) : null;
	}


}
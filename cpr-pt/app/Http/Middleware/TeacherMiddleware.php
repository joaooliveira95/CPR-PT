<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class TeacherMiddleware{
    

    public function handle($request, Closure $next){
    	if(Auth::user()->role_id!=1 && Auth::user()->role_id!=3){
	    	return redirect('/home');
	    }
	    return $next($request);
	    
    }
}

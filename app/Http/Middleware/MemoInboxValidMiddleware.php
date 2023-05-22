<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class MemoInboxValidMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $params = $request->route()->parameters();

        if($params['id'] != Auth::user()->id){
                abort(401, 'Unauthorized action.');
        }else{
            return $next($request);
        }
    }
}

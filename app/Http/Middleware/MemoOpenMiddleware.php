<?php

namespace App\Http\Middleware;

use App\Memo;
use Closure;
use Illuminate\Support\Facades\Auth;

class MemoOpenMiddleware
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
        $token = $request->route()->parameter('id');
        $memo = Memo::where('token', $token)->first();
        $roles = Auth::user()->roles()->first()->name;
        if ($roles == 'super') {
            return $next($request);
        }else{
            if($memo->from_memo != Auth::user()->id){
                abort(401, 'Unauthorized action.');
            }else{
                return $next($request);
            }        
        }
    }
}

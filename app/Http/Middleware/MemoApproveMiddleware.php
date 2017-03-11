<?php

namespace App\Http\Middleware;

use App\Memo;
use Closure;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Support\Facades\Auth;

class MemoApproveMiddleware
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
        $id = $request->route()->parameter('process');
        
        $memo = Memo::find($id);
        $roles = Auth::user()->roles()->first()->name;
        if ($roles == 'super') {
            return $next($request);
        }else{
            if($memo->to_memo != Auth::user()->id){
                abort(401, 'Unauthorized action.');
            }else{
                return $next($request);
            }        
        }
    }
}

<?php

namespace App\Http\Middleware;

use App\Memo;
use Closure;
use Illuminate\Support\Facades\Auth;

class MemoPrepaymentFinishMiddleware
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
        $ct = $request->input('category');
        if($ct){
            $user = Auth::user()->id;
            $memo = Memo::where('from_memo', $user)
                ->where('prepayment_total', '>',0)
                ->where('prepayment_no', null)
                ->where('prepayment_finish', 1)
                ->where('category_id', $ct)
                ->count();
        
            if ($memo >= 3) {
                return view('errors.prepayment', compact('memo'));
                abort(401, 'Please claim your memo prepayment first');
            }else{
                return $next($request);
            }
        }

        return $next($request);
    }
}

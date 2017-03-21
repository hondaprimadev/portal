<?php

namespace App\Http\Middleware;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

use Closure;

class CheckForMaintenanceMode
{
    protected  $requests;
    protected $app;

    public function __construct(Application $app, Request $requests)
    {
        $this->app= $app;
        $this->requests = $requests;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
<<<<<<< HEAD
        $ip = array('127.0.0.1','192.168.10.203','192.168.55.31');
        if ($this->app->isDownForMaintenance() && !in_array($this->request->getClientIp(), $ip)) {
            // return response('Be right back! ' . $this->request->getClientIp() .  , 500);
=======
        // return response($request->ip(), 503);
        if ($this->app->isDownForMaintenance() && !in_array($request->ip(), []))
        {
>>>>>>> 6d3d4a28aae5071a3f63e8b0b9ce8de0da767590
            throw new HttpException(503);
        }

        return $next($request);
    }
}

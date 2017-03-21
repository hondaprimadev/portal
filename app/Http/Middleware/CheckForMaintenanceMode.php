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
        if ($this->app->isDownForMaintenance() && !in_array($request->ip(), ['127.0.0.1','192.168.10.203']))
        {
            throw new HttpException(503);
        }

        return $next($request);
    }
}

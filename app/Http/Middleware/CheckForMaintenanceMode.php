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
        // return response($request->ip(), 503);
        if ($this->app->isDownForMaintenance() && !in_array($request->ip(), []))
        {
            throw new HttpException(503);
        }

        return $next($request);
    }
}

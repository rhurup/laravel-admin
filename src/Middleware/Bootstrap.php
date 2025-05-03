<?php

namespace Rhurup\Admin\Middleware;

use Illuminate\Http\Request;
use Rhurup\Admin\Facades\Admin;

class Bootstrap
{
    public function handle(Request $request, \Closure $next)
    {
        Admin::bootstrap();

        return $next($request);
    }
}

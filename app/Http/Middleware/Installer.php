<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class Installer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!( config('install') && config('install.installed') && Hash::check('installed', config('install.installed')) )) {
            return redirect('/installer/welcome');
        }

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use App\Models\Vendor;

class AdminAccess
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
        if (strpos($request->requestUri, '/activate') !== false) return $next($request);

        if (Auth::check()) {
            $user = $request->user();
            if ($user->role_id == 7) {
                return $next($request);
            } else if ($user->role_id == 4) {
                $vendor = Vendor::where('user_id', $user->id)->first();
                
                if ($vendor->status) {
                    return $next($request);
                } else {
                    Auth::logout();
                    return redirect('login');
                }
            } else if ($user->role_id == 8) {
                if ($request->method() == 'POST' || $request->method() == 'PUT' || $request->method() == 'DELETE' ) {
                    if ($request->ajax()) return response(Lang::get('custom.unauthorized'), 401);
                    return back()->withErrors(Lang::get('custom.unauthorized'));
                }

                return $next($request);
            } else {
                Auth::logout();
                return redirect('login');
            }
        } else {
            return $next($request);
        }

    }
}

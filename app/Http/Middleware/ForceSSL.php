<?php

namespace App\Http\Middleware;

use Closure;

class ForceSSL
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
        if (!$request->isSecure()) {
            return redirect($request->path(), 302, array(), true);
        }
        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $seg = $request->expectsJson() ? 2 : 1;
        app()->setLocale($request->segment($seg));
        URL::defaults(['locale' => $request->segment($seg)]);

        // To solve the segment problem?
        $request->route()->forgetParameter('locale');
        return $next($request);
    }
}

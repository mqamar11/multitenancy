<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Tenant;

class IdentifyTenant
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
         $subdomain = explode('.', $request->getHost())[0];
         $tenant = Tenant::where('subdomain', $subdomain)->firstOrFail();
         app()->instance(Tenant::class, $tenant);
         return $next($request);
    }
}

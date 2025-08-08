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
        // dd([
        //     'host' => $request->getHost(),
        //     'http_host' => $request->server->get('HTTP_HOST'),
        //     'server' => $request->server->get('SERVER_NAME'),
        // ]);
         $host = $request->getHost();
           if (app()->environment('testing')) {
        $host = $request->server->get('HTTP_HOST') ?? $host;
    }
        $subdomain = explode('.', $host)[0];
        $tenant = Tenant::where('subdomain', $subdomain)->first();
        if (!$tenant) {
            abort(403, 'Tenant not found');
        }

        app()->instance('currentTenant', $tenant);

    return $next($request);
    }
}

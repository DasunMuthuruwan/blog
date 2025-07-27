<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class BlockAnonymousProxies
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $ip = $request->ip();

        if ($this->isTorExitNode($ip)) {
            Log::info("blocklist to detect: {$request->ip()}");
            abort(403, 'Access denied.');
        }

        return $next($request);
    }

    private function isTorExitNode($ip)
    {
        // Use an API or blocklist to detect Tor exit nodes
        return in_array($ip, Cache::remember('tor_exit_nodes', 3600, function () {
            return file(config('app.tor_proxy_url'));
        }));
    }
}

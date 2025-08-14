<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Jaybizzle\CrawlerDetect\CrawlerDetect;
use Symfony\Component\HttpFoundation\Response;

class BlockCrawlers
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $crawler = new CrawlerDetect;

        if ($crawler->isCrawler()) {
            Log::info("Crawler blocked: {$request->userAgent()}");
            
            return response()->view('front.pages.errors.403', [], 403);
        }

        return $next($request);
    }
}

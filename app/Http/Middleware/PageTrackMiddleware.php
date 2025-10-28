<?php

namespace App\Http\Middleware;

use Closure;
use App\Services\PageViewService;

class PageTrackMiddleware
{
    public function handle($request, Closure $next, $pageKey)
    {
        $response = $next($request);

        $hasFbclid = $request->has('fbclid');
        PageViewService::track($pageKey, $hasFbclid);

        return $response;
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class LogHttpRequests
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($this->shouldSkipLogging($request)) {
            return $next($request);
        }

        Log::channel('requests')->info('API Request', [
            'time' => now()->format('Y-m-d H:i:s'),
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'body' => $request->all()
        ]);
        return $next($request);
    }


    private function shouldSkipLogging(Request $request): bool
    {
        // Skip logging for high freq hits -
        return $request->is('health') ||
            $request->is('metrics') ||
            $request->is('ping');
    }
}

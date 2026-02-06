<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
         $response = $next($request);

        if (auth()->check()) {
            LogActivite::create([
                'user_id' => auth()->id(),
                'action' => $request->method() . ' ' . $request->path(),
                'description' => 'IP: ' . $request->ip()
            ]);
        }
        return $response;
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\LogActivite;

class LogActivity
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (auth()->check()) {
            try {
                LogActivite::create([
                    'user_id' => auth()->id(),
                    'action' => $request->method() . ' ' . $request->path(),
                    'description' => 'IP: ' . $request->ip()
                ]);
            } catch (\Exception $e) {
                // Ne pas bloquer la requête en cas d'erreur de log
                \Log::error('Erreur lors de la création du log: ' . $e->getMessage());
            }
        }

        return $response;
    }
}
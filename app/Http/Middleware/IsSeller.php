<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsSeller
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        if (auth()->check() && auth()->user()->user_state === 'seller') {
            return $next($request);
        }

        return redirect()->back()->with('message', [
            'type' => 'error',
            'text' => 'Only sellers can access this page.'
        ]);
    }
}

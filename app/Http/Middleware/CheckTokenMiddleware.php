<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CheckTokenMiddleware
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
        $response = Http::baseUrl(config('services.kfit.urls.auth'))
            ->acceptJson()
            ->withToken($request->bearerToken())
            ->get('/api/v1/users/me');

        if($response->json('message') !== 'Unauthenticated.') {
            $request->merge(['apiUser' => $response->json('data')]);

            return $next($request);
        }

        abort(403, $response->json('message'));
    }
}

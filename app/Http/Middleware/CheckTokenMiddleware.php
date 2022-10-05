<?php

namespace App\Http\Middleware;

use App\Utils\User\ApiUser;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CheckTokenMiddleware
{
    private ApiUser $apiUser;

    public function __construct(ApiUser $apiUser)
    {
        $this->apiUser = $apiUser;
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param ApiUser $apiUser
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $response = Http::withAuth()->get('/api/v1/users/me');

        if($response->json('message') !== 'Unauthenticated.') {
            $this->apiUser->setUser($response->json('data'));

            return $next($request);
        }

        abort(403, $response->json('message'));
    }
}

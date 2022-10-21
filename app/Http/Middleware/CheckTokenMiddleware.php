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
    public function handle(Request $request, Closure $next, string $status)
    {
        $response = Http::withAuth()->get('/api/v1/users/me');

        if ($status === 'silence' && !$this->isAuth($response)) {
            $this->apiUser->setUser([]);

            return $next($request);
        }

        if ($this->isAuth($response)) {
            $this->apiUser->setUser($response->json('data'));

            return $next($request);
        }

        abort(403, $response->json('message'));
    }

    private function isAuth($response): bool
    {
        return $response->json('message') !== 'Unauthenticated.';
    }
}

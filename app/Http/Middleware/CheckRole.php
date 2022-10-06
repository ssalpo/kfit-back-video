<?php

namespace App\Http\Middleware;

use App\Utils\User\ApiUser;
use Closure;
use Illuminate\Http\Request;

class CheckRole
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
     * @param string $role
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        if(!$this->apiUser->hasRole($role)) {
            abort(403, 'У вас недостаточно прав для выполнения данного действия!');
        }

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use App\Traits\ApiResponses;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserIsAgent
{
    use ApiResponses;

    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $user = auth()->user();
        if (!$user) {
            return $this->respondUnauthorized(message: 'Unauthorized: No user logged in.');
        }

        if ($user->role_name !== 'agent') {
            return $this->respondNotAllowed(message: 'Forbidden: User is not an Agent.');
        }

        return $next($request);
    }
}

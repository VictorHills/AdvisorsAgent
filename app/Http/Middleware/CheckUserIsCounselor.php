<?php

namespace App\Http\Middleware;

use App\Traits\ApiResponses;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserIsCounselor
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

        if ($user->role_name !== 'counselor') {
            return $this->respondNotAllowed(message: 'Forbidden: User is not a Counselor.');
        }

        return $next($request);
    }
}

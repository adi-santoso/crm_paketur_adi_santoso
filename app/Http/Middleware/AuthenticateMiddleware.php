<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class AuthenticateMiddleware extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     * @throws AuthenticationException
     */
    protected function redirectTo(Request $request): void
    {
        if (! $request->expectsJson())
            throw new AuthenticationException();
    }
}

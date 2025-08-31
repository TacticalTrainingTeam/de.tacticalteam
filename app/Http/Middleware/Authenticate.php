<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if (!$request->expectsJson()) {
            // Save where the user wanted to go
            session()->put('url.intended', $request->fullUrl());

            // Redirect to Larascord’s login route
            return route('login');
        }
        return null;
    }
}

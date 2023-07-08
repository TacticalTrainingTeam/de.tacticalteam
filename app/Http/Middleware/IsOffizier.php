<?php

namespace App\Http\Middleware;

use App\Enums\Roles;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsOffizier
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (User::UserIn(Roles::Offizier) === false) {
            return redirect()->route('start')->withErrors('Du bist kein Offizier, deswegen ist dir der Zugriff verweigert.');
        }
        return $next($request);
    }
}

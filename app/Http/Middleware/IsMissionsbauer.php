<?php

namespace App\Http\Middleware;

use App\Enums\Roles;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsMissionsbauer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (User::UserIn(Roles::Missionsbauer) === false && User::UserIn(Roles::Trainer) === false) {
            return redirect()->route('start')->withErrors('Du bist weder Missionsbauer noch Trainer, deswegen ist dir der Zugriff verweigert.');
        }
        return $next($request);
    }
}

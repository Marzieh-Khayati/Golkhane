<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class CheckUserAccessToSessionsList
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $user): Response
    {
        $userFromUrl = $request->route('user'); // دریافت مقدار {user} از URL
        $loggedInUserId = auth()->user()->id;

        if ($loggedInUserId != $userFromUrl) {
            abort(404);
        }

        return $next($request);
    }
}

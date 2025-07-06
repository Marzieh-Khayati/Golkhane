<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\ConsultationSession;
use Illuminate\Support\Facades\Log;

class CheckUserAccessToChat
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    public function handle(Request $request, Closure $next): Response
    {
        $userFromUrl = $request->route('userId'); // دریافت مقدار {user} از URL
        $sessionFromUrl = $request->route('sessionId');
        $loggedInUserId = auth()->user()->id;

        if ($loggedInUserId != $userFromUrl) {
            abort(404);
        }

        $session = ConsultationSession::find($sessionFromUrl);
        if($userFromUrl != $session->doctor_id && $userFromUrl != $session->customer_id)
            abort(404);

        return $next($request);
    }
}

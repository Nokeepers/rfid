<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyDeviceToken
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $request->header('X-Device-Token') ?? $request->input('token');

        if ($token !== config('services.rfid.device_token')) {
            return response()->json(['error' => 'Unauthorized device'], 401);
        }

        return $next($request);
    }
}

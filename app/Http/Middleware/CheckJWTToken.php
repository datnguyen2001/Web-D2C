<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class CheckJWTToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = JWTAuth::getToken();

        if (!$token) {
            return response()->json(['error' => 'Token not provided'], 401);
        }

        $tokenExists = UserToken::where('token', $token)->exists();

        if (!$tokenExists) {
            return response()->json(['error' => 'Token not found'], 401);
        }

        try {
            $user = JWTAuth::authenticate($token);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Token is invalid'], 401);
        }

        return $next($request);
    }
}

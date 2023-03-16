<?php

namespace App\Http\Middleware;

use App\Utils\ConstantMessage\ConstantPermissionMessage;
use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class ProtectedUserRoute
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            JWTAuth::parseToken()->authenticate();
        } catch (\Exception $e) {
            if ($e instanceof TokenInvalidException || $e instanceof TokenExpiredException) {
                return response()->json(['status' => 'Token is Expired']);
            }
            return response()->json(['status' => ConstantPermissionMessage::TOKEN_NOT_FOUND]);
        }
        return $next($request);
    }
}

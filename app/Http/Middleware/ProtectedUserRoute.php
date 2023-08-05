<?php

namespace App\Http\Middleware;

use App\Utils\ConstantMessage\ConstantPermissionMessage;
use ArrayObject;
use Closure;
use Exception;
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
            $this->me();
            JWTAuth::parseToken()->authenticate();
        } catch (\Exception $e) {
            if ($e instanceof TokenInvalidException || $e instanceof TokenExpiredException) {
                return response()->json(['status' => ConstantPermissionMessage::TOKEN_EXPIRED]);
            }
            return response()->json(['status' => ConstantPermissionMessage::TOKEN_NOT_FOUND]);
        }
        return $next($request);
    }

    public function me()
    {   
        $auth = response()->json(auth('api')->user());
        if($auth->original instanceof ArrayObject) 
        {
            throw new Exception(ConstantPermissionMessage::AUTHORIZATION_NOT_FOUND, 401);
        }
        
        $permission = $auth->original->rules->permission;
        
        if (!isset($permission)) {
            throw new Exception(ConstantPermissionMessage::AUTHORIZATION_NOT_FOUND, 401);
        }

        if ($permission !== "user") {
            throw new Exception(ConstantPermissionMessage::USER_NOT_PERMISSION, 401);
        }
    }

    public function logout()
    {
        try {
            auth('api')->logout();
            return response()->json(['message' => ConstantPermissionMessage::LOGOUT]);
        } catch (\Exception $e) {
            if ($e instanceof TokenInvalidException || $e instanceof TokenExpiredException) {
                return response()->json(['status' => ConstantPermissionMessage::TOKEN_EXPIRED]);
            }
            return response()->json(['status' => $e->getMessage()]);
        }
    }
}

<?php

namespace App\Http\Middleware;


use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use App\Utils\ConstantMessage\ConstantPermissionMessage;
use Exception;

class ProtectedAdmRoute
{

    public function handle(Request $request, Closure $next)
    {
        try {
            $this->me();
            JWTAuth::parseToken()->authenticate();
        } catch (\Exception $e) {
            if ($e instanceof TokenInvalidException || $e instanceof TokenExpiredException) {
                return response()->json(['status' => ConstantPermissionMessage::TOKEN_EXPIRED]);
            }
            return response()->json(['status' => $e->getMessage()]);
        }
        return $next($request);
    }

    public function me()
    {
        $auth = response()->json(auth('api')->user());
        $permission = $auth->original->rules->permission;

        if (!isset($permission)) {
            throw new Exception(ConstantPermissionMessage::AUTHORIZATION_NOT_FOUND, 401);
        }

        if ($permission !== "admin") {
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

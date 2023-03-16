<?php

namespace App\Http\Middleware;


use Closure;
use Illuminate\Http\Request;
use App\Exceptions\CustomException;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Exceptions\NotFoundmonException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use App\Utils\ConstantMessage\ConstantPermissionMessage;

class ProtectedAdmRoute
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
                return response()->json(['status' =>ConstantPermissionMessage::TOKEN_EXPIRED]);
            }
            return response()->json(['status' => $e->getMessage()]);
        }
        return $next($request);
    }

    public function me()
    {
        $auth = response()->json(auth('api')->user());
        if (!isset($auth->original->rule_id)) {
            throw new CustomException(ConstantPermissionMessage::AUTHORIZATION_NOT_FOUND, 401);
        }

        if ($auth->original->rule_id !== 1) {
            throw new CustomException(ConstantPermissionMessage::USER_NOT_PERMISSION, 401);
        }
    }
}

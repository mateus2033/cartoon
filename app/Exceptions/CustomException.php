<?php

namespace App\Exceptions;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Log;

class CustomException
{
    public static function exception($error = null, int $status = Response::HTTP_INTERNAL_SERVER_ERROR)
    {
        if ($error instanceof HttpResponseException) {
            return $error->getResponse();
        }
        
        if (is_array($error) || is_string($error)) {
            Log::info("Exceção lançada: " . json_encode($error));
            abort(response()->json(['error' => $error],$status));
        }
     
        abort(response()->json(
                Lang::get("messages.errors.unexpected_error"),
                Response::HTTP_INTERNAL_SERVER_ERROR
            )
        );
    }
}

<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CustomException  extends Exception
{

    public function __construct($message)
    {
        parent::__construct($message);
        Log::info("Exceção personalizada lançada: " . $message);
    }


    public function render($request, Exception $exception)
    {
        if ($exception instanceof CustomException) {
            return response()->view('erros.minhaexcecao', [], 500);
        }
        //return parent::render($request, $exception);
    }
}

<?php

namespace App\Exceptions;

use Exception;
use Log;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class NotAuthorisedException extends Exception implements CustomExceptionInterface
{
    /**
     * Report the exception.
     */
    public function report(): void
    {
        Log::debug('401');
    }
 
    /**
     * Render the exception into an HTTP response.
     */
    public function render(Request $request): JsonResponse
    {
        return response()->json(['message' => $this->getMessage()], 401);
    }
}

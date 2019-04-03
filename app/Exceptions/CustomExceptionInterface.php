<?php

namespace App\Exceptions;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

interface CustomExceptionInterface
{
    /**
     * Report the exception.
     */
    public function report(): void;
 
    /**
     * Render the exception into an HTTP response.
     */
    public function render(Request $request): JsonResponse;
}

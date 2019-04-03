<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof \Symfony\Component\Debug\Exception\FatalErrorException) {
            return response()->json(['message' => $exception->getMessage()], 500);
        } else if ($exception instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
            return response()->json(['message' => 'The page you requested could not be found.'], 404);
        } else if ($exception instanceof \Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException)  {
            return response()->json(['message' => $exception->getMessage()], 401);
        } else if ($exception instanceof \Tymon\JWTAuth\Exceptions\TokenBlacklistedException)  {
            return response()->json(['message' => $exception->getMessage()], 401);
        } else if ($exception instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException)  {
            return response()->json(['message' => $exception->getMessage()], 401);
        } else if ($exception instanceof \App\Exceptions\CustomExceptionInterface)  {
            //catch all custom errors from here on all exception classes sharing the CustomExceptionInterfaces
            return $exception->render($request);
        }
        return parent::render($request, $exception);
    }
}

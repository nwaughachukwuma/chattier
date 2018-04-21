<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

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
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
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
        if ($request->ajax()) {
            $responseMap = [
                ModelNotFoundException::class => ['resource_not_found', 404],
                UnauthorizedHttpException::class => ['jwt_refresh', 401],
                JWTException::class => ['jwt_absent', 401],
                TokenBlacklistedException::class => ['jwt_blacklisted', 401],
                TokenExpiredException::class => ['jwt_expired', 401],
                TokenInvalidException::class => ['jwt_invalid', 401],
            ];

            if (array_key_exists($class = get_class($exception), $responseMap)) {
                [$message, $status] = $responseMap[$class];
                return response()->json(compact('message'), $status);
            }
        }

        return parent::render($request, $exception);
    }
}

<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    // Optional: customize JSON responses for API
    protected function prepareJsonResponse($request, Throwable $e)
    {
        return response()->json([
            'message' => $e->getMessage() ?: 'Server Error',
            'exception' => class_basename($e),
        ], $this->isHttpException($e) ? $e->getStatusCode() : 500);
    }

    // Optional: always return JSON for API routes
    protected function shouldReturnJson($request, Throwable $e)
    {
        return $request->is('api/*') || $request->expectsJson();
    }
}
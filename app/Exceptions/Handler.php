<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Http\Request;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->renderable(function (NotFoundHttpException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'message' => 'Not found.'
                ], 404);
            }
        });
    }

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof \Laravel\Passport\Exceptions\MissingScopeException)
        {
          return response()->json(['message' => 'tidak punya hak akses'], Response::HTTP_FORBIDDEN);
        }

        return parent::render($request, $exception);
    }
}

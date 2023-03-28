<?php

namespace App\Exceptions;

use Throwable;
use LaravelJsonApi\Exceptions\ExceptionParser;
use LaravelJsonApi\Core\Exceptions\JsonApiException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        JsonApiException::class,
        BusinessException::class,
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
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
        $this->renderable(function (BusinessException $e, Request $request) {
            if ($request->is('open-api/*')) {
                $json = [
                    'success' => false,
                    'error' => $e->getMessage(),
                ];

                return response()->json($json, 400);
            }

            return redirect()->back()->with('error', $e->getMessage())->withInput();
        });

        $this->renderable(
            ExceptionParser::make()->renderable()
        );



        $this->reportable(function (Throwable $e) {
            //
        });
    }
}

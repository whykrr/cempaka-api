<?php

namespace App\Exceptions;

use Throwable;
use App\Constant\RespondMessage;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Validation\ValidationException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
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
     *
     * @return void
     */
    public function register()
    {
        $this->renderable(function (TokenInvalidException $e, $request) {
            return Response::json(['error' => 'Invalid token'], 401);
        });
        $this->renderable(function (TokenExpiredException $e, $request) {
            return Response::json(['error' => 'Token has Expired'], 401);
        });

        $this->renderable(function (JWTException $e, $request) {
            return Response::json(['error' => 'Token not parsed'], 401);
        });

        // error not found
        $this->renderable(function (NotFoundHttpException $e, $request) {
            if ($request->is('api/*')) {
                if ($e->getPrevious() instanceof ModelNotFoundException) {
                    return response()->json([
                        'message' => RespondMessage::ERROR_NOT_FOUND,
                    ], JsonResponse::HTTP_NOT_FOUND);
                }
                return response()->json([
                    'status' => 404,
                    'message' => RespondMessage::ERROR_TARGET_NOT_FOUND,
                ], 404);
            }
        });

        // set globaly error query exeption
        $this->renderable(function (QueryException $e, $request) {
            if ($request->is('api/*')) {
                // get env value
                $env = env('APP_ENV');

                if ($env == 'local') {
                    return response()->json([
                        'message' => $e->getMessage(),
                    ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
                }

                return response()->json([
                    'message' => 'Something went wrong',
                ], 500);
            }
        });

        // set globaly error validation
        $this->renderable(function (ValidationException $e, $request) {
            return response()->json([
                'message' => RespondMessage::ERROR_VALIDATION,
                'validation_error' => $e->validator->errors(),
            ], 400);
        });
    }
}

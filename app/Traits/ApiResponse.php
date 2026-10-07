<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponse
{
    protected function successResponse($data = null, string $message = null, int $code = 200): JsonResponse
    {
        return response()->json([
            'status'  => true,
            'mesaj'   => $message,
            'data'    => $data
        ], $code);
    }

    protected function errorResponse(string $message = null, int $code = 400, $errors = null): JsonResponse
    {
        return response()->json([
            'status' => false,
            'mesaj'  => $message,
            'errors' => $errors
        ], $code);
    }
}
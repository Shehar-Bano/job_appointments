<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;

class ResponseHelper
{
    public static function success($data, int $statusCode = 200): JsonResponse
    {
        return response()->json([
            'success' => true,

            'data' => $data,
        ], $statusCode);
    }

    public static function successMessage(string $message = 'Operation successful', int $statusCode = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,

        ], $statusCode);
    }

    public static function error(string $message, int $statusCode = 400, $error = null): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'error' => $error,
        ], $statusCode);
    }
}

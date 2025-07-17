<?php

namespace App\Helpers;

use Symfony\Component\HttpFoundation\JsonResponse;

class ApiResponse
{
    /**
     * API success response
     * @param array|object $data
     * @param string $message
     * @param int $statusCode
     * 
     * @return JsonResponse
     */
    public static function success(array|object $data, string $message = "", int $statusCode = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], $statusCode);
    }

    /**
     * API error response
     * @param string $message
     * @param int $statusCode
     * 
     * @return JsonResponse
     */
    public static function error(string $message, int $statusCode = 400): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message
        ], $statusCode);
    }

    
    /**
     * API validation error response
     * @param array $errors
     * 
     * @return JsonResponse
     */
    public static function validationError(array $errors): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => 'Validation errors',
            'errors' => $errors
        ], 422);
    }
}

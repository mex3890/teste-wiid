<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ApiBaseController extends Controller
{
    public function sendResponse(
        string       $message,
        string|array|object $data = [],
        string       $custom_key = 'data',
        bool         $success = true,
        int          $status_code = Response::HTTP_OK
    ): JsonResponse
    {
        if (!empty($data)) {
            return response()->json([
                'success' => $success,
                'message' => $message,
                $custom_key => $data,
            ], $status_code);
        }

        return response()->json(['success' => $success, 'message' => $message], $status_code);
    }

    public function sendErrorResponse(
        string       $error_message,
        string|array $errors = [],
        int          $status_code = Response::HTTP_NOT_FOUND
    ): JsonResponse
    {
        return $this->sendResponse($error_message, $errors, 'errors', false, $status_code);
    }
}

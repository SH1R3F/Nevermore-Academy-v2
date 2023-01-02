<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

trait ApiResponse
{
    public function apiResponse(string $message, array $data = null, int $status = Response::HTTP_OK): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'success' => $this->success($status),
            'data' => $data,
        ], $status);
    }

    private function success(int $status): bool
    {
        return in_array($status, [
            Response::HTTP_OK,
            Response::HTTP_ACCEPTED,
            Response::HTTP_CREATED,
            Response::HTTP_NO_CONTENT,
        ]);
    }
}

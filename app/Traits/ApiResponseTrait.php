<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponseTrait
{
    protected function success(array $data = null, int $code = 200): JsonResponse
    {
        $response = config('rc.successfully');
        $response['data'] = $data;

        return response()->json($response, $code);
    }

    protected function createSuccess(array $data = null, int $code = 201): JsonResponse
    {
        $response = config('rc.create_successfully');
        $response['data'] = $data;

        return response()->json($response, $code);
    }
}

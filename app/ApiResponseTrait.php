<?php

namespace App;

use Illuminate\Http\JsonResponse;

trait ApiResponseTrait
{
    public function successResponse($data = null, $message = 'Operação realizada com sucesso.', $statusCode = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
            'errors' => null,
        ], $statusCode);
    }

    public function errorResponse($data = null, $message = 'Erro ao realizar operação.', $statusCode = 400, $errors = null)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data' => $data,
            'errors' => $errors,
        ], $statusCode);
    }
}

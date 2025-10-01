<?php

namespace App\Traits;

use Symfony\Component\HttpFoundation\JsonResponse;

trait Generics
{
    /**
     * @param  boolean $success
     * @param  string  $message
     * @param  mixed   $data
     * @return JsonResponse
     */
    public function handleReturn(bool $success = true, string $message = '', mixed $data = null, int $code = 200): JsonResponse
    {
        return response()->json([
            'success' => $success,
            'message' => $message,
            'data'    => $data
        ], $code);
    }
}
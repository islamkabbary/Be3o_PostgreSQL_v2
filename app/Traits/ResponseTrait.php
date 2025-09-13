<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;

trait ResponseTrait
{
    public function success(mixed $data = [], ?string $message = 'Success', int $statusCode = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'code'    => $statusCode,
            'message' => __($message),
            'data'    => $data
        ], $statusCode);
    }

    public function paginated(LengthAwarePaginator $paginator, ?string $message = 'Success', int $statusCode = 200): JsonResponse
    {
        $response = [
            'success' => true,
            'code'    => $statusCode,
            'message' => $message,
            'data'    => $paginator->items(),
            'pagination' => [
                'current_page'   => $paginator->currentPage(),
                'total_pages'    => $paginator->lastPage(),
                'items_per_page' => $paginator->perPage(),
                'total_items'    => $paginator->total(),
                'next_page_url'  => $paginator->nextPageUrl(),
                'prev_page_url'  => $paginator->previousPageUrl(),
            ]
        ];

        return response()->json($response, $statusCode)
            ->header('X-Total-Count', $paginator->total())
            ->header('X-Total-Pages', $paginator->lastPage())
            ->header('X-Per-Page', $paginator->perPage())
            ->header('X-Current-Page', $paginator->currentPage());
    }

    public function error($errors = [], ?string $message = 'Error', int $statusCode = 400): JsonResponse
    {
        return response()->json([
            'success' => false,
            'code'    => $statusCode,
            'message' => $message,
            'errors'  => $errors,
            'data'    => null
        ], $statusCode);
    }
}

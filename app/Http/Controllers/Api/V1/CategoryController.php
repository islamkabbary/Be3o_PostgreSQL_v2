<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Services\CategoryService;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    protected CategoryService $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * GET /api/categories
     */
    public function index(): JsonResponse
    {
        $categories = $this->categoryService->getAllCategories();

        return $this->paginated($categories);
    }

    public function children(int $id): JsonResponse
    {
        $category = $this->categoryService->getCategoryChildren($id);

        if (!$category) {
            return $this->error([], __('Category not found'), 404);
        }

        return $this->success([
            'category' => new CategoryResource($category),
        ], __('Category fetched successfully'));
    }

    public function listAttributes(int $id): JsonResponse
    {
        $attributes = $this->categoryService->listAttributes($id);

        if (empty($attributes)) {
            return $this->error([], __('Category not found or has no attributes'), 404);
        }

        return $this->success([
            'category_id' => $id,
            'attributes' => $attributes,
        ], __('Category attributes fetched successfully'));
    }
}

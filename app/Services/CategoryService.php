<?php

namespace App\Services;

use App\Interfaces\CategoryRepositoryInterface;
use App\Models\Category;
use Illuminate\Support\Collection;

class CategoryService
{
    protected $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Get all categories (with optional caching or business logic later)
     */
    public function getAllCategories()
    {
        return $this->categoryRepository->getAllActive();
    }


    public function getCategoryChildren(int $id): ?Category
    {
        return $this->categoryRepository->getCategoryWithChildren($id);
    }
}

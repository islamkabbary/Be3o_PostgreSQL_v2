<?php

namespace App\Repositories;

use App\Interfaces\CategoryRepositoryInterface;
use App\Models\Category;
use Illuminate\Support\Collection;

class CategoryRepository implements CategoryRepositoryInterface
{
    /**
     * Get all active categories ordered by sort_order.
     */
    public function getAllActive()
    {
        return Category::query()
            ->where('is_active', true)
            ->paginate(10);
    }

    public function getCategoryWithChildren(int $id): ?Category
    {
        return Category::with('children')->find($id);
    }
}

<?php

namespace App\Repositories;

use App\Models\Category;
use App\Models\CategoryAttribute;
use Illuminate\Support\Collection;
use App\Interfaces\CategoryRepositoryInterface;

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

    public function getAttributes(int $categoryId)
    {
        $category = Category::with('attributes')->find($categoryId);

        if (!$category) {
            return [];
        }

        return $category->attributes->map(fn($attr) => [
            'id' => $attr->id,
            'name' => $attr->name,
            'name_ar' => $attr->name_ar,
            'type' => $attr->attribute_type,
            'options' => $attr->options ?? [],
            'is_required' => $attr->is_required,
        ])->toArray();
    }
}

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

    public function getAttributes(int $categoryId): array
    {
        $category = Category::with([
            'attributes' => function ($query) {
                $query->select('category_attributes.id', 'name', 'attribute_type', 'options', 'is_required');
            }
        ])->findOrFail($categoryId);

        $attributes = $category->attributes;

        return $attributes->map(fn($attr) => [
            'id' => $attr->id,
            'name' => $attr->getTranslations('name'),
            'type' => $attr->attribute_type,
            'options' => $attr->options ?? [],
            'is_required' => (bool) $attr->is_required,
        ])->toArray();
    }
}

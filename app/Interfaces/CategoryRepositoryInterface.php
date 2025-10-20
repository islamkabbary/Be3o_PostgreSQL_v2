<?php

namespace App\Interfaces;

use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Collection;

interface CategoryRepositoryInterface
{
    public function getAllActive();
    public function getCategoryWithChildren(int $id): ?Category;
    public function getAttributes(int $categoryId);
}

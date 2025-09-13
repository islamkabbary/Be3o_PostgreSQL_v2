<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'name_ar',
        'slug',
        'description',
        'icon_url',
        'image_url',
        'sort_order',
        'is_active',
        'meta_title',
        'meta_description',
    ];

    public function subcategories()
    {
        return $this->hasMany(Subcategory::class);
    }

    public function categoryAttributes()
    {
        return $this->hasMany(CategoryAttribute::class);
    }

    public function listings()
    {
        return $this->hasMany(Listing::class);
    }
}
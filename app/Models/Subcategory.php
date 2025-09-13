<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'parent_id',
        'name',
        'name_ar',
        'slug',
        'description',
        'icon_url',
        'sort_order',
        'is_active',
        'requires_verification',
        'allows_negotiation',
        'meta_title',
        'meta_description',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function parent()
    {
        return $this->belongsTo(Subcategory::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Subcategory::class, 'parent_id');
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
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'name',
        'name_ar',
        'slug',
        'description',
        'icon_url',
        'image_url',
        'sort_order',
        'is_active',
        'requires_verification',
        'allows_negotiation',
        'meta_title',
        'meta_description',
    ];

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function attributes()
    {
        return $this->hasMany(CategoryAttribute::class);
    }

    public function listings()
    {
        return $this->hasMany(Listing::class);
    }
}

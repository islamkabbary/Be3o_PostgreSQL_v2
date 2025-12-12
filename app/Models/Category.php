<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Category extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        'parent_id',
        'name',
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

    public $translatable = ['name', 'description', 'meta_title', 'meta_description'];

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
        return $this->belongsToMany(CategoryAttribute::class, 'category_attribute');
    }

    public function ads()
    {
        return $this->hasMany(Ad::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class CategoryAttribute extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        'category_id',
        'name',
        'attribute_type',
        'is_required',
        'is_searchable',
        'is_filterable',
        'options',
        'validation_rules',
        'sort_order',
    ];

    public $translatable = ['name'];
    protected $casts = [
        'options' => 'array',
        'validation_rules' => 'array',
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_attribute');
    }

    public function adAttributes()
    {
        return $this->hasMany(AdAttribute::class, 'attribute_id');
    }
}
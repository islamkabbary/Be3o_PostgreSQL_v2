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

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function listingAttributes()
    {
        return $this->hasMany(ListingAttribute::class, 'attribute_id');
    }
}
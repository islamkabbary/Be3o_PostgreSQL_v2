<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListingAttribute extends Model
{
    use HasFactory;

    protected $fillable = [
        'listing_id',
        'attribute_id',
        'value_text',
        'value_number',
        'value_boolean',
        'value_date',
        'value_json',
    ];

    protected $casts = [
        'value_json' => 'array',
    ];

    public function listing()
    {
        return $this->belongsTo(Listing::class);
    }

    public function attribute()
    {
        return $this->belongsTo(CategoryAttribute::class, 'attribute_id');
    }
}
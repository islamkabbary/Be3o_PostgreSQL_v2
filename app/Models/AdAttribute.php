<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdAttribute extends Model
{
    use HasFactory;

    protected $fillable = [
        'ad_id',
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

    public function ad()
    {
        return $this->belongsTo(Ad::class);
    }

    public function attribute()
    {
        return $this->belongsTo(CategoryAttribute::class, 'attribute_id');
    }
}
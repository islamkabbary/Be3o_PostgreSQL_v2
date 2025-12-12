<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'ad_id',
        'image_url',
        'thumbnail_url',
        'alt_text',
        'sort_order',
        'is_primary',
        'file_size',
        'image_width',
        'image_height',
    ];

    public function ad()
    {
        return $this->belongsTo(Ad::class);
    }
}
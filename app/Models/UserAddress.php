<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'label',
        'country',
        'governorate',
        'city',
        'area',
        'street_address',
        'building_number',
        'apartment_number',
        'postal_code',
        'landmark',
        'latitude',
        'longitude',
        'is_primary',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
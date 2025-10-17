<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'description',
        'price',
        'currency',
        'price_negotiable',
        'condition',
        'country',
        'governorate',
        'city',
        'area',
        'latitude',
        'longitude',
        'status',
        'listing_type',
        'is_featured',
        'is_urgent',
        'is_premium',
        'auto_renew',
        'priority_score',
        'contact_count',
        'favorite_count',
        'slug',
        'meta_title',
        'meta_description',
        'published_at',
        'expires_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function listingAttributes()
    {
        return $this->hasMany(ListingAttribute::class);
    }

    public function listingImages()
    {
        return $this->hasMany(ListingImage::class);
    }

    public function conversations()
    {
        return $this->hasMany(Conversation::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }
}
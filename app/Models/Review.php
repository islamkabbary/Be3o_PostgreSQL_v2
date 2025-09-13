<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'reviewer_id',
        'reviewee_id',
        'listing_id',
        'rating',
        'title',
        'comment',
        'transaction_type',
        'is_verified',
        'is_anonymous',
        'status',
        'helpful_count',
    ];

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }

    public function reviewee()
    {
        return $this->belongsTo(User::class, 'reviewee_id');
    }

    public function listing()
    {
        return $this->belongsTo(Listing::class);
    }

    public function reviewVotes()
    {
        return $this->hasMany(ReviewVote::class);
    }
}
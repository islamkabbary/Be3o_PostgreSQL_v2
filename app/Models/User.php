<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'email',
        'phone',
        'password',
        'first_name',
        'last_name',
    ];

    protected $hidden = [
        'password',
    ];
    public function userProfile()
    {
        return $this->hasOne(UserProfile::class);
    }

    public function userAddresses()
    {
        return $this->hasMany(UserAddress::class);
    }

    public function listings()
    {
        return $this->hasMany(Listing::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function savedSearches()
    {
        return $this->hasMany(SavedSearch::class);
    }

    public function reviewsAsReviewer()
    {
        return $this->hasMany(Review::class, 'reviewer_id');
    }

    public function reviewsAsReviewee()
    {
        return $this->hasMany(Review::class, 'reviewee_id');
    }

    public function reviewVotes()
    {
        return $this->hasMany(ReviewVote::class);
    }

    public function ordersAsBuyer()
    {
        return $this->hasMany(Order::class, 'buyer_id');
    }

    public function ordersAsSeller()
    {
        return $this->hasMany(Order::class, 'seller_id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function reportsAsReporter()
    {
        return $this->hasMany(Report::class, 'reporter_id');
    }

    public function reportsAsReported()
    {
        return $this->hasMany(Report::class, 'reported_user_id');
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function userActivityLogs()
    {
        return $this->hasMany(UserActivityLog::class);
    }

    public function conversationsAsBuyer()
    {
        return $this->hasMany(Conversation::class, 'buyer_id');
    }

    public function conversationsAsSeller()
    {
        return $this->hasMany(Conversation::class, 'seller_id');
    }

    public function messagesAsSender()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function messagesAsRecipient()
    {
        return $this->hasMany(Message::class, 'recipient_id');
    }
}

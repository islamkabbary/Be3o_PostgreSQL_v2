<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'about_me',
        'business_name',
        'business_type',
        'company_size',
        'website_url',
        'social_facebook',
        'social_instagram',
        'social_twitter',
        'trade_license',
        'tax_number',
        'notification_email',
        'notification_sms',
        'notification_push',
        'privacy_show_phone',
        'privacy_show_email',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
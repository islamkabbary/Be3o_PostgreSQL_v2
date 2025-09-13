<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'plan_id',
        'status',
        'start_date',
        'end_date',
        'cost',
        'discount_percentage',
        'is_free',
        'granted_by',
        'reason',
        'payment_method_note',
        'notes',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plan()
    {
        return $this->belongsTo(SubscriptionPlan::class, 'plan_id');
    }

    public function grantedBy()
    {
        return $this->belongsTo(AdminUser::class, 'granted_by');
    }
}
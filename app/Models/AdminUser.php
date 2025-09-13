<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'password',
        'first_name',
        'last_name',
        'role',
        'permissions',
        'is_active',
        'last_login_at',
    ];

    protected $casts = [
        'permissions' => 'array',
    ];
}
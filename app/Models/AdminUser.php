<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class AdminUser extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $table = 'admin_users';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $hidden = ['password_hash'];

    protected $casts = [
        'last_login_at' => 'datetime',
    ];

    /** The column that stores the hashed password (non-standard name). */
    public function getAuthPassword(): string
    {
        return $this->password_hash;
    }

    public function isSuperadmin(): bool
    {
        return $this->role === 'superadmin';
    }
}

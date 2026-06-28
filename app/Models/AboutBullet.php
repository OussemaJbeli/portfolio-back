<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutBullet extends Model
{
    protected $table = 'about_bullets';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}

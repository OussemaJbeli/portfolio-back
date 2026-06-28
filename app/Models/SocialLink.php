<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialLink extends Model
{
    protected $table = 'social_links';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}

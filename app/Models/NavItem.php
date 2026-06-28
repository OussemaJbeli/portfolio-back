<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NavItem extends Model
{
    protected $table = 'nav_items';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}

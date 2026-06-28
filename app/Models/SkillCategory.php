<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SkillCategory extends Model
{
    protected $table = 'skill_categories';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'percentage' => 'integer',
        'is_active' => 'boolean',
    ];
}

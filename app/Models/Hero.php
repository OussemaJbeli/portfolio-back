<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hero extends Model
{
    protected $table = 'hero';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'typewriter_en' => 'array',
        'typewriter_fr' => 'array',
        'typewriter_ar' => 'array',
    ];
}

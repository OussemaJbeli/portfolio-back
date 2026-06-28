<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    protected $table = 'contact_messages';

    // Table has only `created_at` (DB default) and no `updated_at`.
    public $timestamps = false;

    protected $guarded = ['id', 'created_at'];

    protected $casts = [
        'is_read' => 'boolean',
        'created_at' => 'datetime',
    ];
}

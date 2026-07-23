<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TechnologyGroup extends Model
{
    protected $table = 'technology_groups';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /** Technologies filed under this group. */
    public function technologies(): HasMany
    {
        return $this->hasMany(Technology::class, 'group_id')->orderBy('sort_order');
    }
}

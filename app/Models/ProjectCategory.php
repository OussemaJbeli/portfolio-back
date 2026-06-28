<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProjectCategory extends Model
{
    protected $table = 'project_categories';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class, 'category_id');
    }
}

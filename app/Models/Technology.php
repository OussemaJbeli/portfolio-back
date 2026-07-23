<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Technology extends Model
{
    protected $table = 'technologies';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'is_featured' => 'boolean',
    ];

    /** Skill bucket this technology belongs to (nullable). */
    public function group(): BelongsTo
    {
        return $this->belongsTo(TechnologyGroup::class, 'group_id');
    }

    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class, 'project_technologies', 'technology_id', 'project_id')
            ->withPivot('sort_order');
    }
}

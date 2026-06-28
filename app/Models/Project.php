<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    protected $table = 'projects';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'completed_date' => 'date',
    ];

    /** Resolve route-model bindings (e.g. /projects/{project}) by slug. */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ProjectCategory::class, 'category_id');
    }

    public function gallery(): HasMany
    {
        return $this->hasMany(ProjectGallery::class)->orderBy('sort_order');
    }

    public function features(): HasMany
    {
        return $this->hasMany(ProjectFeature::class)->orderBy('sort_order');
    }

    public function roles(): HasMany
    {
        return $this->hasMany(ProjectRole::class)->orderBy('sort_order');
    }

    public function technologies(): BelongsToMany
    {
        return $this->belongsToMany(Technology::class, 'project_technologies', 'project_id', 'technology_id')
            ->withPivot('sort_order')
            ->orderBy('project_technologies.sort_order');
    }
}

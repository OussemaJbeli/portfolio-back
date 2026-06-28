<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Technology extends Model
{
    protected $table = 'technologies';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class, 'project_technologies', 'technology_id', 'project_id')
            ->withPivot('sort_order');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectRole extends Model
{
    protected $table = 'project_roles';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}

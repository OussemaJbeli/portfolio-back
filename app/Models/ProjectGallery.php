<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectGallery extends Model
{
    protected $table = 'project_gallery';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}

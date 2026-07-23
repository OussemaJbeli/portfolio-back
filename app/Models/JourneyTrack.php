<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JourneyTrack extends Model
{
    protected $table = 'journey_tracks';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'started_at' => 'date',
        'ended_at' => 'date',
        'merged_at' => 'date',
        'is_active' => 'boolean',
    ];

    /** Resolve route-model bindings (e.g. /journey-tracks/{track}) by slug. */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /** Commits on this branch, in chronological order. */
    public function milestones(): HasMany
    {
        return $this->hasMany(JourneyMilestone::class, 'track_id')->orderBy('happened_at');
    }

    /** The branch this one merges back into (usually main). */
    public function mergesInto(): BelongsTo
    {
        return $this->belongsTo(JourneyTrack::class, 'merges_into_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class JourneyMilestone extends Model
{
    protected $table = 'journey_milestones';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'happened_at' => 'date',
        'is_highlight' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Auto-generate the deterministic fake commit hash from the track slug +
     * English title, only when one hasn't been set. Runs on Eloquent writes
     * (admin CRUD); the seeder computes the same value itself since it uses the
     * query builder (and DatabaseSeeder mutes model events).
     */
    protected static function booted(): void
    {
        static::saving(function (JourneyMilestone $milestone): void {
            if (empty($milestone->commit_hash)) {
                $slug = $milestone->track?->slug
                    ?? JourneyTrack::whereKey($milestone->track_id)->value('slug')
                    ?? '';
                $milestone->commit_hash = substr(sha1($slug.'|'.$milestone->title_en), 0, 7);
            }
        });
    }

    public function track(): BelongsTo
    {
        return $this->belongsTo(JourneyTrack::class, 'track_id');
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function technologies(): BelongsToMany
    {
        return $this->belongsToMany(Technology::class, 'journey_milestone_technologies', 'milestone_id', 'technology_id')
            ->withPivot('sort_order')
            ->orderBy('journey_milestone_technologies.sort_order');
    }
}

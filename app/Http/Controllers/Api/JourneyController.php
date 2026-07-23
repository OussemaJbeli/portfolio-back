<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JourneyMilestone;
use App\Models\JourneySection;
use App\Models\JourneyTrack;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;

/**
 * GET /api/journey — the whole "git log --graph --all" in one payload:
 * section config, computed header stats, and every active branch (track) with
 * its commits (milestones) eager-loaded, ordered by date. Locale is resolved
 * client-side (all _en/_fr/_ar are returned), like the other sections.
 */
class JourneyController extends Controller
{
    public function index(): JsonResponse
    {
        $tracks = JourneyTrack::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->with(['milestones' => function ($q) {
                $q->where('is_active', true)
                    ->with([
                        'project:id,slug,thumbnail_url,title_en,title_fr,title_ar',
                        'technologies',
                    ]);
            }])
            ->get();

        // Stats (server-side): years since the earliest branch, parallel
        // non-main branches, and total commits.
        $minStart = JourneyTrack::where('is_active', true)->min('started_at');
        $years = $minStart ? (int) Carbon::parse($minStart)->diffInYears(now()) : 0;
        $branches = JourneyTrack::where('is_active', true)->where('type', '!=', 'main')->count();
        $commits = JourneyMilestone::query()
            ->where('is_active', true)
            ->whereHas('track', fn ($q) => $q->where('is_active', true))
            ->count();

        return response()->json([
            'section' => JourneySection::query()->first(),
            'stats' => [
                'years' => $years,
                'branches' => $branches,
                'commits' => $commits,
            ],
            'tracks' => $tracks,
        ]);
    }
}

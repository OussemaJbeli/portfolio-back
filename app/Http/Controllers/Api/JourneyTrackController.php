<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JourneyTrack;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class JourneyTrackController extends Controller
{
    /** GET /api/admin/journey-tracks. */
    public function index(Request $request)
    {
        $query = JourneyTrack::query()->with('mergesInto');

        if (! $request->is('api/admin/*')) {
            $query->where('is_active', true);
        }

        return $query->orderBy('sort_order')->get();
    }

    /** GET /api/admin/journey-tracks/{track} — bound by slug. */
    public function show(JourneyTrack $track): JourneyTrack
    {
        return $track->load(['mergesInto', 'milestones']);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate($this->rules($request));

        $track = JourneyTrack::create($request->all());

        return response()->json($track, Response::HTTP_CREATED);
    }

    public function update(Request $request, JourneyTrack $track): JourneyTrack
    {
        $request->validate($this->rules($request, $track));

        $track->update($request->all());

        return $track;
    }

    public function destroy(JourneyTrack $track): Response
    {
        $track->delete();

        return response()->noContent();
    }

    private function rules(Request $request, ?JourneyTrack $track = null): array
    {
        return [
            'slug' => ['required', 'string', 'max:80', 'alpha_dash', Rule::unique('journey_tracks', 'slug')->ignore($track)],
            'branch_name' => ['required', 'string', 'max:120'],
            'type' => ['required', Rule::in(['main', 'education', 'work', 'freelance', 'self'])],
            'employment_type' => ['nullable', Rule::in(['full_time', 'part_time', 'internship', 'freelance', 'contract'])],
            'color' => ['nullable', 'string', 'max:7'],
            'icon_class' => ['nullable', 'string', 'max:100'],
            'label_en' => ['required', 'string', 'max:160'],
            'label_fr' => ['nullable', 'string', 'max:160'],
            'label_ar' => ['nullable', 'string', 'max:160'],
            'org_en' => ['nullable', 'string', 'max:160'],
            'org_fr' => ['nullable', 'string', 'max:160'],
            'org_ar' => ['nullable', 'string', 'max:160'],
            'location_en' => ['nullable', 'string', 'max:160'],
            'location_fr' => ['nullable', 'string', 'max:160'],
            'location_ar' => ['nullable', 'string', 'max:160'],
            'started_at' => ['required', 'date'],
            'ended_at' => ['nullable', 'date', 'after_or_equal:started_at'],
            'lane_index' => ['nullable', 'integer', 'min:0', 'max:255'],
            'merges_into_id' => ['nullable', 'integer', 'exists:journey_tracks,id'],
            'merged_at' => ['nullable', 'date'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['boolean'],
        ];
    }
}

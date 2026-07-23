<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JourneyMilestone;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Manage the milestone ↔ technology pivot (journey_milestone_technologies).
 * Mirrors ProjectTechnologyController.
 */
class JourneyMilestoneTechnologyController extends Controller
{
    /** POST — attach a technology (keeps existing ones). */
    public function store(Request $request, JourneyMilestone $milestone)
    {
        $data = $request->validate([
            'technology_id' => ['required', 'integer', 'exists:technologies,id'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $milestone->technologies()->syncWithoutDetaching([
            $data['technology_id'] => ['sort_order' => $data['sort_order'] ?? 0],
        ]);

        return $milestone->technologies()->get();
    }

    /** PUT — replace the whole set in one call. */
    public function sync(Request $request, JourneyMilestone $milestone)
    {
        $data = $request->validate([
            'technology_ids' => ['present', 'array'],
            'technology_ids.*' => ['integer', 'exists:technologies,id'],
        ]);

        $milestone->technologies()->sync($data['technology_ids']);

        return $milestone->technologies()->get();
    }

    /** DELETE — detach a single technology. */
    public function destroy(JourneyMilestone $milestone, int $technology): Response
    {
        $milestone->technologies()->detach($technology);

        return response()->noContent();
    }
}

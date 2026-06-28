<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Manage the project ↔ technology pivot (project_technologies).
 */
class ProjectTechnologyController extends Controller
{
    /** POST — attach a technology (keeps existing ones). */
    public function store(Request $request, Project $project)
    {
        $data = $request->validate([
            'technology_id' => ['required', 'integer', 'exists:technologies,id'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $project->technologies()->syncWithoutDetaching([
            $data['technology_id'] => ['sort_order' => $data['sort_order'] ?? 0],
        ]);

        return $project->technologies()->get();
    }

    /** PUT — replace the whole set in one call. */
    public function sync(Request $request, Project $project)
    {
        $data = $request->validate([
            'technology_ids' => ['present', 'array'],
            'technology_ids.*' => ['integer', 'exists:technologies,id'],
        ]);

        $project->technologies()->sync($data['technology_ids']);

        return $project->technologies()->get();
    }

    /** DELETE — detach a single technology. */
    public function destroy(Project $project, int $technology): Response
    {
        $project->technologies()->detach($technology);

        return response()->noContent();
    }
}

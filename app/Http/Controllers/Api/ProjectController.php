<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class ProjectController extends Controller
{
    /** GET /api/projects (public) | GET /api/admin/projects (admin). */
    public function index(Request $request)
    {
        $isAdmin = $request->is('api/admin/*');

        $query = Project::query()->with(['category', 'technologies']);

        if (! $isAdmin) {
            $query->where('is_active', true);
        }

        if ($request->filled('category')) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $request->string('category')));
        }

        if ($request->boolean('featured')) {
            $query->where('is_featured', true);
        }

        return $query->orderBy('sort_order')->paginate($request->integer('per_page', 12));
    }

    /** GET /api/projects/{project} — bound by slug. */
    public function show(Request $request, Project $project): Project
    {
        if (! $request->is('api/admin/*') && ! $project->is_active) {
            abort(404);
        }

        return $project->load(['category', 'gallery', 'features', 'roles', 'technologies']);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate($this->rules($request));

        $project = Project::create($request->all());

        return response()->json($project->load(['category', 'technologies']), Response::HTTP_CREATED);
    }

    public function update(Request $request, Project $project): Project
    {
        $request->validate($this->rules($request, $project));

        $project->update($request->all());

        return $project->load(['category', 'technologies']);
    }

    public function destroy(Project $project): Response
    {
        $project->delete();

        return response()->noContent();
    }

    private function rules(Request $request, ?Project $project = null): array
    {
        return [
            'slug' => ['required', 'string', 'max:200', 'alpha_dash', Rule::unique('projects', 'slug')->ignore($project)],
            'category_id' => ['nullable', 'integer', 'exists:project_categories,id'],
            'project_type' => ['nullable', Rule::in(['freelance', 'professional', 'academic', 'personal'])],
            'thumbnail_url' => ['nullable', 'url', 'max:500'],
            'is_featured' => ['boolean'],
            'is_active' => ['boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'title_en' => ['required', 'string', 'max:200'],
            'title_fr' => ['nullable', 'string', 'max:200'],
            'title_ar' => ['nullable', 'string', 'max:200'],
            'completed_date' => ['nullable', 'date'],
            'live_demo_url' => ['nullable', 'url', 'max:500'],
            'github_url' => ['nullable', 'url', 'max:500'],
        ];
    }
}

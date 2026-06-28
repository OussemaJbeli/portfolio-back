<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectFeature;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProjectFeatureController extends Controller
{
    public function index(Project $project)
    {
        return $project->features;
    }

    public function store(Request $request, Project $project): JsonResponse
    {
        $data = $request->validate($this->rules());

        return response()->json($project->features()->create($data), Response::HTTP_CREATED);
    }

    public function show(ProjectFeature $feature): ProjectFeature
    {
        return $feature;
    }

    public function update(Request $request, ProjectFeature $feature): ProjectFeature
    {
        $feature->update($request->validate($this->rules()));

        return $feature;
    }

    public function destroy(ProjectFeature $feature): Response
    {
        $feature->delete();

        return response()->noContent();
    }

    private function rules(): array
    {
        return [
            'text_en' => ['required', 'string', 'max:500'],
            'text_fr' => ['nullable', 'string', 'max:500'],
            'text_ar' => ['nullable', 'string', 'max:500'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ];
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectRole;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProjectRoleController extends Controller
{
    public function index(Project $project)
    {
        return $project->roles;
    }

    public function store(Request $request, Project $project): JsonResponse
    {
        $data = $request->validate($this->rules());

        return response()->json($project->roles()->create($data), Response::HTTP_CREATED);
    }

    public function show(ProjectRole $role): ProjectRole
    {
        return $role;
    }

    public function update(Request $request, ProjectRole $role): ProjectRole
    {
        $role->update($request->validate($this->rules()));

        return $role;
    }

    public function destroy(ProjectRole $role): Response
    {
        $role->delete();

        return response()->noContent();
    }

    private function rules(): array
    {
        return [
            'icon_class' => ['nullable', 'string', 'max:100'],
            'title_en' => ['required', 'string', 'max:150'],
            'title_fr' => ['nullable', 'string', 'max:150'],
            'title_ar' => ['nullable', 'string', 'max:150'],
            'body_en' => ['nullable', 'string'],
            'body_fr' => ['nullable', 'string'],
            'body_ar' => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ];
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectGallery;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProjectGalleryController extends Controller
{
    public function index(Project $project)
    {
        return $project->gallery;
    }

    public function store(Request $request, Project $project): JsonResponse
    {
        $data = $request->validate($this->rules());

        return response()->json($project->gallery()->create($data), Response::HTTP_CREATED);
    }

    public function show(ProjectGallery $gallery): ProjectGallery
    {
        return $gallery;
    }

    public function update(Request $request, ProjectGallery $gallery): ProjectGallery
    {
        $gallery->update($request->validate($this->rules()));

        return $gallery;
    }

    public function destroy(ProjectGallery $gallery): Response
    {
        $gallery->delete();

        return response()->noContent();
    }

    private function rules(): array
    {
        return [
            'image_url' => $this->imageUrlRules(true),
            'alt_en' => ['nullable', 'string', 'max:255'],
            'alt_fr' => ['nullable', 'string', 'max:255'],
            'alt_ar' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ];
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogToc;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BlogTocController extends Controller
{
    public function index(Blog $blog)
    {
        return $blog->toc;
    }

    public function store(Request $request, Blog $blog): JsonResponse
    {
        $data = $request->validate($this->rules());

        return response()->json($blog->toc()->create($data), Response::HTTP_CREATED);
    }

    public function show(BlogToc $toc): BlogToc
    {
        return $toc;
    }

    public function update(Request $request, BlogToc $toc): BlogToc
    {
        $toc->update($request->validate($this->rules()));

        return $toc;
    }

    public function destroy(BlogToc $toc): Response
    {
        $toc->delete();

        return response()->noContent();
    }

    private function rules(): array
    {
        return [
            'anchor' => ['required', 'string', 'max:150'],
            'label_en' => ['required', 'string', 'max:200'],
            'label_fr' => ['nullable', 'string', 'max:200'],
            'label_ar' => ['nullable', 'string', 'max:200'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ];
    }
}

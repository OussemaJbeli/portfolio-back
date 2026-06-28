<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class BlogController extends Controller
{
    /** GET /api/blogs (public) | GET /api/admin/blogs (admin). */
    public function index(Request $request)
    {
        $isAdmin = $request->is('api/admin/*');

        $query = Blog::query()->with('categories');

        if (! $isAdmin) {
            $query->where('is_active', true);
        }

        if ($request->filled('category')) {
            $query->whereHas('categories', fn ($q) => $q->where('slug', $request->string('category')));
        }

        if ($request->boolean('featured')) {
            $query->where('is_featured', true);
        }

        return $query->orderByDesc('published_at')->paginate($request->integer('per_page', 9));
    }

    /** GET /api/blogs/{blog} — bound by slug. */
    public function show(Request $request, Blog $blog): Blog
    {
        if (! $request->is('api/admin/*')) {
            if (! $blog->is_active) {
                abort(404);
            }
            $blog->increment('views');
        }

        return $blog->load(['categories', 'toc', 'relatedArticles']);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate($this->rules($request));

        $blog = Blog::create($request->all());

        return response()->json($blog->load('categories'), Response::HTTP_CREATED);
    }

    public function update(Request $request, Blog $blog): Blog
    {
        $request->validate($this->rules($request, $blog));

        $blog->update($request->all());

        return $blog->load('categories');
    }

    public function destroy(Blog $blog): Response
    {
        $blog->delete();

        return response()->noContent();
    }

    private function rules(Request $request, ?Blog $blog = null): array
    {
        return [
            'slug' => ['required', 'string', 'max:300', 'alpha_dash', Rule::unique('blogs', 'slug')->ignore($blog)],
            'title_en' => ['required', 'string', 'max:300'],
            'title_fr' => ['nullable', 'string', 'max:300'],
            'title_ar' => ['nullable', 'string', 'max:300'],
            'cover_image_url' => ['nullable', 'url', 'max:500'],
            'read_time_minutes' => ['nullable', 'integer', 'min:0', 'max:255'],
            'is_featured' => ['boolean'],
            'is_active' => ['boolean'],
            'published_at' => ['nullable', 'date'],
        ];
    }
}

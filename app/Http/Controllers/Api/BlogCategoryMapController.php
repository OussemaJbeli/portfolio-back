<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Manage the blog ↔ category pivot (blog_category_map).
 */
class BlogCategoryMapController extends Controller
{
    /** POST — attach a category (keeps existing ones). */
    public function store(Request $request, Blog $blog)
    {
        $data = $request->validate([
            'category_id' => ['required', 'integer', 'exists:blog_categories,id'],
        ]);

        $blog->categories()->syncWithoutDetaching([$data['category_id']]);

        return $blog->categories()->get();
    }

    /** PUT — replace the whole set in one call. */
    public function sync(Request $request, Blog $blog)
    {
        $data = $request->validate([
            'category_ids' => ['present', 'array'],
            'category_ids.*' => ['integer', 'exists:blog_categories,id'],
        ]);

        $blog->categories()->sync($data['category_ids']);

        return $blog->categories()->get();
    }

    /** DELETE — detach a single category. */
    public function destroy(Blog $blog, int $category): Response
    {
        $blog->categories()->detach($category);

        return response()->noContent();
    }
}

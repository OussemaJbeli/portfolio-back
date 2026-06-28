<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

/**
 * Manage the editorial "related articles" pivot (blog_related).
 */
class BlogRelatedController extends Controller
{
    /** POST — link a related article. */
    public function store(Request $request, Blog $blog)
    {
        $data = $request->validate([
            'related_id' => ['required', 'integer', 'exists:blogs,id'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        // Enforce in the app what MySQL 8 won't let us CHECK on an FK column:
        // an article may not be related to itself.
        if ((int) $data['related_id'] === $blog->id) {
            throw ValidationException::withMessages([
                'related_id' => ['An article cannot be related to itself.'],
            ]);
        }

        $blog->relatedArticles()->syncWithoutDetaching([
            $data['related_id'] => ['sort_order' => $data['sort_order'] ?? 0],
        ]);

        return $blog->relatedArticles()->get();
    }

    /** DELETE — unlink a related article. */
    public function destroy(Blog $blog, int $related): Response
    {
        $blog->relatedArticles()->detach($related);

        return response()->noContent();
    }
}

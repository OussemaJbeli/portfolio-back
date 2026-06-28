<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

/**
 * Image uploads for the CMS. Files are stored under `public/assets/<folder>`,
 * one folder per content area, and served directly by the web server.
 *
 * Returns an absolute URL (built from the request host) so the value can be
 * stored straight into a `*_url` column that the API validates as a URL.
 */
class UploadController extends Controller
{
    /** Content areas allowed to receive uploads. */
    private const FOLDERS = [
        'hero', 'about', 'stats', 'skills', 'technologies',
        'projects', 'blogs', 'author', 'social', 'site',
    ];

    /** POST /api/admin/uploads — store an image, return its URL. */
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'image' => ['required', 'file', 'image', 'max:5120'], // 5 MB; allows jpg/png/webp/gif/svg
            'folder' => ['required', 'string', Rule::in(self::FOLDERS)],
        ]);

        $folder = $data['folder'];
        $file = $request->file('image');

        $extension = strtolower($file->getClientOriginalExtension() ?: ($file->guessExtension() ?? 'bin'));
        $name = Str::random(24).'.'.$extension;

        $directory = public_path("assets/{$folder}");
        File::ensureDirectoryExists($directory, 0755);
        $file->move($directory, $name);

        $path = "/assets/{$folder}/{$name}";

        return response()->json([
            'url' => $request->getSchemeAndHttpHost().$path,
            'path' => $path,
            'folder' => $folder,
            'name' => $name,
        ], Response::HTTP_CREATED);
    }

    /** DELETE /api/admin/uploads?path=/assets/<folder>/<file> — remove a file. */
    public function destroy(Request $request): Response
    {
        $data = $request->validate([
            'path' => ['required', 'string'],
        ]);

        // Accept either a bare path or a full URL; keep only the path part.
        $path = ltrim(parse_url($data['path'], PHP_URL_PATH) ?: $data['path'], '/');
        $segments = explode('/', $path);

        // Must be exactly assets/<allowed-folder>/<file> — no traversal.
        abort_unless(
            count($segments) === 3
                && $segments[0] === 'assets'
                && in_array($segments[1], self::FOLDERS, true)
                && ! str_contains($path, '..'),
            Response::HTTP_UNPROCESSABLE_ENTITY,
            'Invalid asset path.'
        );

        $full = public_path($path);
        if (File::exists($full)) {
            File::delete($full);
        }

        return response()->noContent();
    }
}

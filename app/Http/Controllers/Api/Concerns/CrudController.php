<?php

namespace App\Http\Controllers\Api\Concerns;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Shared CRUD for the simple "list" resources.
 *
 * Public reads (anything not under /api/admin/*) are limited to active rows
 * and ordered by `sort_order`; the admin surface sees everything. Writes are
 * only reachable through the auth-protected admin routes.
 */
abstract class CrudController extends Controller
{
    /** @var class-string<Model> */
    protected string $model;

    protected bool $filtersActive = true;

    protected bool $ordered = true;

    /**
     * Validation rules. `$model` is null on create and the existing record on
     * update (so unique rules can ignore the current row).
     */
    protected function rules(Request $request, ?Model $model = null): array
    {
        return [];
    }

    public function index(Request $request)
    {
        $query = $this->model::query();

        if ($this->filtersActive && ! $request->is('api/admin/*')) {
            $query->where('is_active', true);
        }

        if ($this->ordered) {
            $query->orderBy('sort_order');
        }

        return $query->get();
    }

    public function show(Request $request, string $id): Model
    {
        return $this->model::findOrFail($id);
    }

    public function store(Request $request): JsonResponse
    {
        if ($rules = $this->rules($request)) {
            $request->validate($rules);
        }

        $model = $this->model::create($request->all());

        return response()->json($model, Response::HTTP_CREATED);
    }

    public function update(Request $request, string $id): Model
    {
        $model = $this->model::findOrFail($id);

        if ($rules = $this->rules($request, $model)) {
            $request->validate($rules);
        }

        $model->update($request->all());

        return $model;
    }

    public function destroy(string $id): Response
    {
        $this->model::findOrFail($id)->delete();

        return response()->noContent();
    }
}

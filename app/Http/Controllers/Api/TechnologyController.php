<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Concerns\CrudController;
use App\Models\Technology;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TechnologyController extends CrudController
{
    protected string $model = Technology::class;

    // technologies has no is_active / sort_order columns.
    protected bool $filtersActive = false;

    protected bool $ordered = false;

    public function index(Request $request)
    {
        return Technology::query()->orderBy('name')->get();
    }

    protected function rules(Request $request, ?Model $model = null): array
    {
        return [
            'name' => ['required', 'string', 'max:80', Rule::unique('technologies', 'name')->ignore($model)],
            'icon_url' => ['nullable', 'url', 'max:500'],
            'icon_class' => ['nullable', 'string', 'max:100'],
            'color' => ['nullable', 'string', 'max:7'],
            'is_featured' => ['sometimes', 'boolean'],
            'group_id' => ['nullable', 'integer', 'exists:technology_groups,id'],
            'proficiency' => ['sometimes', Rule::in(['core', 'proficient', 'familiar'])],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ];
    }
}

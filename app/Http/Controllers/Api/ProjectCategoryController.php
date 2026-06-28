<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Concerns\CrudController;
use App\Models\ProjectCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProjectCategoryController extends CrudController
{
    protected string $model = ProjectCategory::class;

    protected function rules(Request $request, ?Model $model = null): array
    {
        return [
            'slug' => ['required', 'string', 'max:80', 'alpha_dash', Rule::unique('project_categories', 'slug')->ignore($model)],
            'name_en' => ['required', 'string', 'max:100'],
            'name_fr' => ['nullable', 'string', 'max:100'],
            'name_ar' => ['nullable', 'string', 'max:100'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['boolean'],
        ];
    }
}

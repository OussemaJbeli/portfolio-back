<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Concerns\CrudController;
use App\Models\SkillCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class SkillCategoryController extends CrudController
{
    protected string $model = SkillCategory::class;

    protected function rules(Request $request, ?Model $model = null): array
    {
        return [
            'name_en' => ['required', 'string', 'max:120'],
            'name_fr' => ['nullable', 'string', 'max:120'],
            'name_ar' => ['nullable', 'string', 'max:120'],
            'percentage' => ['required', 'integer', 'between:0,100'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['boolean'],
        ];
    }
}

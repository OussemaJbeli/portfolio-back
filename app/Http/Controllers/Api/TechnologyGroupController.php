<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Concerns\CrudController;
use App\Models\TechnologyGroup;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TechnologyGroupController extends CrudController
{
    protected string $model = TechnologyGroup::class;

    /** Public reads embed the grouped technologies (ordered). */
    public function index(Request $request)
    {
        $query = TechnologyGroup::query()->with('technologies');

        if (! $request->is('api/admin/*')) {
            $query->where('is_active', true);
        }

        return $query->orderBy('sort_order')->get();
    }

    protected function rules(Request $request, ?Model $model = null): array
    {
        return [
            'slug' => ['required', 'string', 'max:80', 'alpha_dash', Rule::unique('technology_groups', 'slug')->ignore($model)],
            'name_en' => ['required', 'string', 'max:120'],
            'name_fr' => ['nullable', 'string', 'max:120'],
            'name_ar' => ['nullable', 'string', 'max:120'],
            'icon_class' => ['nullable', 'string', 'max:100'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['boolean'],
        ];
    }
}

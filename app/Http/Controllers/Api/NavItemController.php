<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Concerns\CrudController;
use App\Models\NavItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class NavItemController extends CrudController
{
    protected string $model = NavItem::class;

    protected function rules(Request $request, ?Model $model = null): array
    {
        return [
            'route_key' => ['required', 'string', 'max:50', Rule::unique('nav_items', 'route_key')->ignore($model)],
            'href' => ['required', 'string', 'max:200'],
            'label_en' => ['required', 'string', 'max:80'],
            'label_fr' => ['nullable', 'string', 'max:80'],
            'label_ar' => ['nullable', 'string', 'max:80'],
            'icon_class' => ['nullable', 'string', 'max:100'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['boolean'],
        ];
    }
}

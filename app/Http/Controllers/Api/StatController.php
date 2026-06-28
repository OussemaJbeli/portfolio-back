<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Concerns\CrudController;
use App\Models\Stat;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class StatController extends CrudController
{
    protected string $model = Stat::class;

    protected function rules(Request $request, ?Model $model = null): array
    {
        return [
            'value' => ['required', 'string', 'max:20'],
            'icon_class' => ['nullable', 'string', 'max:100'],
            'label_en' => ['required', 'string', 'max:100'],
            'label_fr' => ['nullable', 'string', 'max:100'],
            'label_ar' => ['nullable', 'string', 'max:100'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['boolean'],
        ];
    }
}

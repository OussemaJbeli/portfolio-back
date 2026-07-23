<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Concerns\CrudController;
use App\Models\Interest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class InterestController extends CrudController
{
    protected string $model = Interest::class;

    protected function rules(Request $request, ?Model $model = null): array
    {
        return [
            'name_en' => ['required', 'string', 'max:80'],
            'name_fr' => ['nullable', 'string', 'max:80'],
            'name_ar' => ['nullable', 'string', 'max:80'],
            'icon_class' => ['nullable', 'string', 'max:100'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['boolean'],
        ];
    }
}

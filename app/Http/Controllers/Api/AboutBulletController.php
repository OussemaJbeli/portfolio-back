<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Concerns\CrudController;
use App\Models\AboutBullet;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class AboutBulletController extends CrudController
{
    protected string $model = AboutBullet::class;

    protected function rules(Request $request, ?Model $model = null): array
    {
        return [
            'icon_class' => ['nullable', 'string', 'max:100'],
            'text_en' => ['required', 'string', 'max:255'],
            'text_fr' => ['nullable', 'string', 'max:255'],
            'text_ar' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['boolean'],
        ];
    }
}

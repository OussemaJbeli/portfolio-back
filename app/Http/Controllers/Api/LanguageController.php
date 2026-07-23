<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Concerns\CrudController;
use App\Models\Language;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LanguageController extends CrudController
{
    protected string $model = Language::class;

    protected function rules(Request $request, ?Model $model = null): array
    {
        return [
            'name_en' => ['required', 'string', 'max:80'],
            'name_fr' => ['nullable', 'string', 'max:80'],
            'name_ar' => ['nullable', 'string', 'max:80'],
            'level' => ['required', Rule::in(['native', 'c2', 'c1', 'b2', 'b1', 'a2', 'a1'])],
            'note_en' => ['nullable', 'string', 'max:160'],
            'note_fr' => ['nullable', 'string', 'max:160'],
            'note_ar' => ['nullable', 'string', 'max:160'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['boolean'],
        ];
    }
}

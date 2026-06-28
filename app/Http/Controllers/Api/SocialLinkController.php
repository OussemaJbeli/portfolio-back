<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Concerns\CrudController;
use App\Models\SocialLink;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class SocialLinkController extends CrudController
{
    protected string $model = SocialLink::class;

    protected function rules(Request $request, ?Model $model = null): array
    {
        return [
            'platform' => ['required', 'string', 'max:50'],
            'url' => ['required', 'url', 'max:500'],
            'icon_class' => ['nullable', 'string', 'max:100'],
            'display_in' => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['boolean'],
        ];
    }
}

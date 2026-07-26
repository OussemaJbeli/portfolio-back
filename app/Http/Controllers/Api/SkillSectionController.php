<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Concerns\SingletonController;
use App\Models\SkillSection;

class SkillSectionController extends SingletonController
{
    protected string $model = SkillSection::class;

    protected function updateRules(): array
    {
        return [
            'section_badge_en' => ['sometimes', 'string', 'max:80'],
            'section_badge_fr' => ['sometimes', 'string', 'max:80'],
            'section_badge_ar' => ['sometimes', 'string', 'max:80'],
            'heading_en' => ['sometimes', 'string', 'max:160'],
            'heading_fr' => ['sometimes', 'string', 'max:160'],
            'heading_ar' => ['sometimes', 'string', 'max:160'],
        ];
    }
}

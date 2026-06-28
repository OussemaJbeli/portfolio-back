<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Concerns\SingletonController;
use App\Models\SkillSection;

class SkillSectionController extends SingletonController
{
    protected string $model = SkillSection::class;
}

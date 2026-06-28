<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Concerns\SingletonController;
use App\Models\ProjectSection;

class ProjectSectionController extends SingletonController
{
    protected string $model = ProjectSection::class;
}

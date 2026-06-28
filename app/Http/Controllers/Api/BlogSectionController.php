<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Concerns\SingletonController;
use App\Models\BlogSection;

class BlogSectionController extends SingletonController
{
    protected string $model = BlogSection::class;
}

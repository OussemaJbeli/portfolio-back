<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Concerns\SingletonController;
use App\Models\About;

class AboutController extends SingletonController
{
    protected string $model = About::class;
}

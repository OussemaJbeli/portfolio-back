<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Concerns\SingletonController;
use App\Models\Hero;

class HeroController extends SingletonController
{
    protected string $model = Hero::class;
}

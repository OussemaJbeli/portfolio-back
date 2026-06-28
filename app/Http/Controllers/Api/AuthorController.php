<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Concerns\SingletonController;
use App\Models\Author;

class AuthorController extends SingletonController
{
    protected string $model = Author::class;
}

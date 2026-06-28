<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Concerns\SingletonController;
use App\Models\ContactSection;

class ContactSectionController extends SingletonController
{
    protected string $model = ContactSection::class;
}

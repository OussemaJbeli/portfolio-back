<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Concerns\SingletonController;
use App\Models\SiteSetting;

class SiteSettingController extends SingletonController
{
    protected string $model = SiteSetting::class;
}

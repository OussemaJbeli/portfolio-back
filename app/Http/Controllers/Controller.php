<?php

namespace App\Http\Controllers;

abstract class Controller
{
    /**
     * Validation rules for an image reference stored in a `*_url` column.
     *
     * Uploaded images are saved as a relative "/assets/<folder>/<file>" path
     * (see UploadController) and the frontend prefixes them with the backend
     * URL when rendering. That relative path is not a valid absolute URL, so
     * the strict `url` rule no longer fits — accept any short string instead.
     */
    protected function imageUrlRules(bool $required = false): array
    {
        return [$required ? 'required' : 'nullable', 'string', 'max:500'];
    }
}

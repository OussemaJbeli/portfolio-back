<?php

namespace App\Http\Controllers\Api\Concerns;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * Shared behaviour for the singleton "section config" resources (one editable
 * row). `show` is public; `update` is reachable only via the admin routes.
 */
abstract class SingletonController extends Controller
{
    /** @var class-string<Model> */
    protected string $model;

    /** Validation rules applied on update. */
    protected function updateRules(): array
    {
        return [];
    }

    /**
     * The single row for this section. Returns an unsaved instance when none
     * exists yet (no write-on-read, and no empty-insert into tables that have
     * NOT NULL columns such as hero/author).
     */
    protected function row(): Model
    {
        return $this->model::query()->firstOrNew([]);
    }

    public function show(): Model
    {
        return $this->row();
    }

    public function update(Request $request): Model
    {
        if ($rules = $this->updateRules()) {
            $request->validate($rules);
        }

        $row = $this->row();
        $row->fill($request->all())->save();

        return $row;
    }
}

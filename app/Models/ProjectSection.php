<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectSection extends Model
{
    protected $table = 'projects_section';

    protected $guarded = ['id', 'created_at', 'updated_at'];
}

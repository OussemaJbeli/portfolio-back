<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SkillSection extends Model
{
    protected $table = 'skills_section';

    protected $guarded = ['id', 'created_at', 'updated_at'];
}

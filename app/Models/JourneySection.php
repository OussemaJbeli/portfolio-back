<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JourneySection extends Model
{
    protected $table = 'journey_section';

    protected $guarded = ['id', 'created_at', 'updated_at'];
}

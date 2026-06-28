<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogSection extends Model
{
    protected $table = 'blogs_section';

    protected $guarded = ['id', 'created_at', 'updated_at'];
}

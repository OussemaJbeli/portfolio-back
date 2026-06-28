<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactSection extends Model
{
    protected $table = 'contact_section';

    protected $guarded = ['id', 'created_at', 'updated_at'];
}

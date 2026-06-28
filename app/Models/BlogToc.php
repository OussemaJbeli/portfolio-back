<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BlogToc extends Model
{
    protected $table = 'blog_toc';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function blog(): BelongsTo
    {
        return $this->belongsTo(Blog::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class BlogCategory extends Model
{
    protected $table = 'blog_categories';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function blogs(): BelongsToMany
    {
        return $this->belongsToMany(Blog::class, 'blog_category_map', 'category_id', 'blog_id');
    }
}

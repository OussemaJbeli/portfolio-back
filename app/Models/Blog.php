<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Blog extends Model
{
    protected $table = 'blogs';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'views' => 'integer',
        'read_time_minutes' => 'integer',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'published_at' => 'datetime',
    ];

    /** Resolve route-model bindings (e.g. /blogs/{blog}) by slug. */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(BlogCategory::class, 'blog_category_map', 'blog_id', 'category_id');
    }

    public function toc(): HasMany
    {
        return $this->hasMany(BlogToc::class)->orderBy('sort_order');
    }

    public function relatedArticles(): BelongsToMany
    {
        return $this->belongsToMany(Blog::class, 'blog_related', 'blog_id', 'related_id')
            ->withPivot('sort_order')
            ->orderBy('blog_related.sort_order');
    }
}

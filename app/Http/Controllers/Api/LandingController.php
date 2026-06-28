<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\AboutBullet;
use App\Models\Author;
use App\Models\Blog;
use App\Models\BlogSection;
use App\Models\ContactSection;
use App\Models\Hero;
use App\Models\NavItem;
use App\Models\Project;
use App\Models\ProjectSection;
use App\Models\SiteSetting;
use App\Models\SkillCategory;
use App\Models\SkillSection;
use App\Models\SocialLink;
use App\Models\Stat;
use App\Models\Technology;
use Illuminate\Http\JsonResponse;

/**
 * GET /api/landing — everything the homepage needs in a single request,
 * so the frontend avoids a waterfall of calls on first paint.
 */
class LandingController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([
            'settings' => SiteSetting::query()->first(),
            'navigation' => NavItem::query()->where('is_active', true)->orderBy('sort_order')->get(),
            'social_links' => SocialLink::query()->where('is_active', true)->orderBy('sort_order')->get(),

            'hero' => Hero::query()->first(),
            'stats' => Stat::query()->where('is_active', true)->orderBy('sort_order')->get(),

            'about' => About::query()->first(),
            'about_bullets' => AboutBullet::query()->where('is_active', true)->orderBy('sort_order')->get(),

            'skills_section' => SkillSection::query()->first(),
            'skill_categories' => SkillCategory::query()->where('is_active', true)->orderBy('sort_order')->get(),
            'technologies' => Technology::query()->orderBy('name')->get(),

            'projects_section' => ProjectSection::query()->first(),
            'featured_projects' => Project::query()
                ->where('is_active', true)->where('is_featured', true)
                ->with(['category', 'technologies'])
                ->orderBy('sort_order')->get(),

            'blogs_section' => BlogSection::query()->first(),
            'recent_blogs' => Blog::query()
                ->where('is_active', true)
                ->with('categories')
                ->orderByDesc('published_at')->limit(3)->get(),

            'contact_section' => ContactSection::query()->first(),
            'author' => Author::query()->first(),
        ]);
    }
}

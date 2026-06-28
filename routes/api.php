<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\LandingController;
use App\Http\Controllers\Api\SiteSettingController;
use App\Http\Controllers\Api\NavItemController;
use App\Http\Controllers\Api\SocialLinkController;
use App\Http\Controllers\Api\HeroController;
use App\Http\Controllers\Api\StatController;
use App\Http\Controllers\Api\AboutController;
use App\Http\Controllers\Api\AboutBulletController;
use App\Http\Controllers\Api\SkillSectionController;
use App\Http\Controllers\Api\SkillCategoryController;
use App\Http\Controllers\Api\TechnologyController;
use App\Http\Controllers\Api\ProjectSectionController;
use App\Http\Controllers\Api\ProjectCategoryController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\ProjectGalleryController;
use App\Http\Controllers\Api\ProjectFeatureController;
use App\Http\Controllers\Api\ProjectRoleController;
use App\Http\Controllers\Api\ProjectTechnologyController;
use App\Http\Controllers\Api\BlogSectionController;
use App\Http\Controllers\Api\BlogCategoryController;
use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\BlogTocController;
use App\Http\Controllers\Api\BlogRelatedController;
use App\Http\Controllers\Api\BlogCategoryMapController;
use App\Http\Controllers\Api\AuthorController;
use App\Http\Controllers\Api\ContactSectionController;
use App\Http\Controllers\Api\ContactMessageController;
use App\Http\Controllers\Api\AdminUserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UploadController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Two surfaces:
|   • PUBLIC  (/api/*)        read-only data for the Vue frontend, plus the
|                             two writes a visitor must perform without
|                             logging in: submitting the contact form and
|                             logging into the CMS.
|   • ADMIN   (/api/admin/*)  full CRUD for the CMS back-office, protected
|                             by `auth:sanctum`.
|
| Controllers are intentionally NOT created yet — these are route
| definitions only. Detail endpoints (projects/{slug}, blogs/{slug}) are
| expected to embed their child records (gallery, features, roles, toc,
| related, technologies, categories) in the response, which is why those
| children have no separate public GET routes.
|
*/

/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/
Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login'])->middleware('throttle:6,1');

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('me', [AuthController::class, 'me']);
        Route::post('logout', [AuthController::class, 'logout']);
    });
});

/*
|--------------------------------------------------------------------------
| Public API (frontend) — read-only
|--------------------------------------------------------------------------
*/

// One-shot payload for the landing page (hero, about, stats, skills, social,
// section configs, navigation, settings) to avoid a waterfall of requests.
Route::get('landing', [LandingController::class, 'index']);

// Global / layout
Route::get('settings', [SiteSettingController::class, 'show']);
Route::get('navigation', [NavItemController::class, 'index']);
Route::get('social-links', [SocialLinkController::class, 'index']);

// Home sections
Route::get('hero', [HeroController::class, 'show']);
Route::get('stats', [StatController::class, 'index']);
Route::get('about', [AboutController::class, 'show']);
Route::get('about-bullets', [AboutBulletController::class, 'index']);
Route::get('skills-section', [SkillSectionController::class, 'show']);
Route::get('skill-categories', [SkillCategoryController::class, 'index']);
Route::get('technologies', [TechnologyController::class, 'index']);

// Projects
Route::get('projects-section', [ProjectSectionController::class, 'show']);
Route::get('project-categories', [ProjectCategoryController::class, 'index']);
Route::get('projects', [ProjectController::class, 'index']);
Route::get('projects/{project}', [ProjectController::class, 'show']);

// Blogs
Route::get('blogs-section', [BlogSectionController::class, 'show']);
Route::get('blog-categories', [BlogCategoryController::class, 'index']);
Route::get('blogs', [BlogController::class, 'index']);
Route::get('blogs/{blog}', [BlogController::class, 'show']);

// Author + contact
Route::get('author', [AuthorController::class, 'show']);
Route::get('contact-section', [ContactSectionController::class, 'show']);

// Public writes
Route::post('contact-messages', [ContactMessageController::class, 'store'])
    ->middleware('throttle:10,1'); // visitor contact form

/*
|--------------------------------------------------------------------------
| Admin API (CMS) — protected by Sanctum
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->middleware('auth:sanctum')->group(function () {

    // ── Image uploads (public/assets/<folder>) ─────────────────────────
    Route::post('uploads', [UploadController::class, 'store']);
    Route::delete('uploads', [UploadController::class, 'destroy']);

    // ── Singleton section configs (show + update) ──────────────────────
    Route::get('settings', [SiteSettingController::class, 'show']);
    Route::put('settings', [SiteSettingController::class, 'update']);

    Route::get('hero', [HeroController::class, 'show']);
    Route::put('hero', [HeroController::class, 'update']);

    Route::get('about', [AboutController::class, 'show']);
    Route::put('about', [AboutController::class, 'update']);

    Route::get('skills-section', [SkillSectionController::class, 'show']);
    Route::put('skills-section', [SkillSectionController::class, 'update']);

    Route::get('projects-section', [ProjectSectionController::class, 'show']);
    Route::put('projects-section', [ProjectSectionController::class, 'update']);

    Route::get('blogs-section', [BlogSectionController::class, 'show']);
    Route::put('blogs-section', [BlogSectionController::class, 'update']);

    Route::get('contact-section', [ContactSectionController::class, 'show']);
    Route::put('contact-section', [ContactSectionController::class, 'update']);

    Route::get('author', [AuthorController::class, 'show']);
    Route::put('author', [AuthorController::class, 'update']);

    // ── Collections (full CRUD) ────────────────────────────────────────
    Route::apiResource('nav-items', NavItemController::class);
    Route::apiResource('social-links', SocialLinkController::class);
    Route::apiResource('stats', StatController::class);
    Route::apiResource('about-bullets', AboutBulletController::class);
    Route::apiResource('skill-categories', SkillCategoryController::class);
    Route::apiResource('technologies', TechnologyController::class);
    Route::apiResource('project-categories', ProjectCategoryController::class);
    Route::apiResource('projects', ProjectController::class);
    Route::apiResource('blog-categories', BlogCategoryController::class);
    Route::apiResource('blogs', BlogController::class);

    // ── Project children (nested, shallow) ─────────────────────────────
    Route::apiResource('projects.gallery', ProjectGalleryController::class)->shallow();
    Route::apiResource('projects.features', ProjectFeatureController::class)->shallow();
    Route::apiResource('projects.roles', ProjectRoleController::class)->shallow();

    // Project ↔ technology pivot (attach / sync / detach)
    Route::post('projects/{project}/technologies', [ProjectTechnologyController::class, 'store']);
    Route::put('projects/{project}/technologies', [ProjectTechnologyController::class, 'sync']);
    Route::delete('projects/{project}/technologies/{technology}', [ProjectTechnologyController::class, 'destroy']);

    // ── Blog children ──────────────────────────────────────────────────
    Route::apiResource('blogs.toc', BlogTocController::class)->shallow();

    // Blog ↔ blog "related articles" (attach / detach)
    Route::post('blogs/{blog}/related', [BlogRelatedController::class, 'store']);
    Route::delete('blogs/{blog}/related/{related}', [BlogRelatedController::class, 'destroy']);

    // Blog ↔ category pivot (attach / sync / detach)
    Route::post('blogs/{blog}/categories', [BlogCategoryMapController::class, 'store']);
    Route::put('blogs/{blog}/categories', [BlogCategoryMapController::class, 'sync']);
    Route::delete('blogs/{blog}/categories/{category}', [BlogCategoryMapController::class, 'destroy']);

    // ── Contact message inbox (read / mark-read / delete) ──────────────
    Route::get('contact-messages', [ContactMessageController::class, 'index']);
    Route::get('contact-messages/{message}', [ContactMessageController::class, 'show']);
    Route::patch('contact-messages/{message}/read', [ContactMessageController::class, 'markRead']);
    Route::delete('contact-messages/{message}', [ContactMessageController::class, 'destroy']);

    // ── Back-office accounts (superadmin) ──────────────────────────────
    Route::apiResource('admin-users', AdminUserController::class);
});

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Projects: filter categories, the project records, their gallery / feature
 * list / role cards, the project↔technology pivot, and the section heading.
 */
return new class extends Migration
{
    public function up(): void
    {
        // 10. PROJECT CATEGORIES — filter tabs on the listing page.
        Schema::create('project_categories', function (Blueprint $table) {
            $table->id();
            $table->string('slug', 80)->unique();
            $table->string('name_en', 100);
            $table->string('name_fr', 100)->nullable();
            $table->string('name_ar', 100)->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['is_active', 'sort_order']);
        });

        // 11. PROJECTS — listing card + full detail page.
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('slug', 200)->unique();
            $table->foreignId('category_id')->nullable()
                ->constrained('project_categories')
                ->nullOnDelete()
                ->cascadeOnUpdate();

            // Listing card
            $table->string('thumbnail_url', 500)->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->unsignedSmallInteger('sort_order')->default(0);

            // Detail hero
            $table->string('title_en', 200);
            $table->string('title_fr', 200)->nullable();
            $table->string('title_ar', 200)->nullable();
            $table->string('subtitle_en', 300)->nullable();
            $table->string('subtitle_fr', 300)->nullable();
            $table->string('subtitle_ar', 300)->nullable();

            // Short description (listing card + detail hero)
            $table->text('description_en')->nullable();
            $table->text('description_fr')->nullable();
            $table->text('description_ar')->nullable();

            // "About the Project" (longer detail copy)
            $table->text('about_en')->nullable();
            $table->text('about_fr')->nullable();
            $table->text('about_ar')->nullable();

            $table->string('hero_image_url', 500)->nullable();

            // Project Info sidebar
            $table->string('client_en', 200)->nullable();
            $table->string('client_fr', 200)->nullable();
            $table->string('client_ar', 200)->nullable();
            $table->string('duration_en', 100)->nullable();
            $table->string('duration_fr', 100)->nullable();
            $table->string('duration_ar', 100)->nullable();
            $table->date('completed_date')->nullable();

            // CTA links
            $table->string('live_demo_url', 500)->nullable();
            $table->string('github_url', 500)->nullable();

            $table->timestamps();

            $table->index(['is_active', 'is_featured', 'sort_order'], 'idx_projects_listing');
        });

        // 12. PROJECT GALLERY — carousel images on the detail page.
        Schema::create('project_gallery', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')
                ->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('image_url', 500);
            $table->string('alt_en', 255)->nullable();
            $table->string('alt_fr', 255)->nullable();
            $table->string('alt_ar', 255)->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();

            // Detail page always pulls a project's images in display order.
            $table->index(['project_id', 'sort_order'], 'idx_project_gallery_order');
        });

        // 13. PROJECT FEATURES — "About the Project" bullet checklist.
        Schema::create('project_features', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')
                ->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('text_en', 500);
            $table->string('text_fr', 500)->nullable();
            $table->string('text_ar', 500)->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });

        // 14. PROJECT ↔ TECHNOLOGY — many-to-many tech-stack badges.
        Schema::create('project_technologies', function (Blueprint $table) {
            $table->foreignId('project_id')->constrained('projects')
                ->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('technology_id')->constrained('technologies')
                ->cascadeOnDelete()->cascadeOnUpdate();
            $table->unsignedSmallInteger('sort_order')->default(0);

            $table->primary(['project_id', 'technology_id']);
        });

        // 15. PROJECT ROLES — "What I Did" cards on the detail page.
        Schema::create('project_roles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')
                ->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('icon_class', 100)->nullable();
            $table->string('title_en', 150);
            $table->string('title_fr', 150)->nullable();
            $table->string('title_ar', 150)->nullable();
            $table->text('body_en')->nullable();
            $table->text('body_fr')->nullable();
            $table->text('body_ar')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });

        // 16. PROJECTS SECTION CONFIG — landing heading + listing-page hero (singleton).
        Schema::create('projects_section', function (Blueprint $table) {
            $table->id();
            $table->string('section_badge_en', 80)->default('> PROJECTS');
            $table->string('section_badge_fr', 80)->default('> PROJETS');
            $table->string('section_badge_ar', 80)->default('> المشاريع');
            $table->string('heading_part1_en', 160)->default('My Projects');
            $table->string('heading_part1_fr', 160)->default('Mes Projets');
            $table->string('heading_part1_ar', 160)->default('مشاريعي');
            $table->string('subheading_en', 500)->nullable();
            $table->string('subheading_fr', 500)->nullable();
            $table->string('subheading_ar', 500)->nullable();

            // Listing page hero
            $table->string('listing_title_part1_en', 160)->default("Things I've");
            $table->string('listing_title_part1_fr', 160)->default("Ce que j'ai");
            $table->string('listing_title_part1_ar', 160)->default('ما قمت');
            $table->string('listing_title_part2_en', 160)->default('Built');
            $table->string('listing_title_part2_fr', 160)->default('Construit');
            $table->string('listing_title_part2_ar', 160)->default('ببنائه');
            $table->string('listing_subtitle_en', 500)->nullable();
            $table->string('listing_subtitle_fr', 500)->nullable();
            $table->string('listing_subtitle_ar', 500)->nullable();

            // CTA
            $table->string('cta_label_en', 80)->default('View All Projects');
            $table->string('cta_label_fr', 80)->default('Voir tous les projets');
            $table->string('cta_label_ar', 80)->default('عرض كل المشاريع');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects_section');
        Schema::dropIfExists('project_roles');
        Schema::dropIfExists('project_technologies');
        Schema::dropIfExists('project_features');
        Schema::dropIfExists('project_gallery');
        Schema::dropIfExists('projects');
        Schema::dropIfExists('project_categories');
    }
};

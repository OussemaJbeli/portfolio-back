<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Blog: tag categories, posts, the post↔category pivot, table of contents,
 * editorial "related articles", and the section heading block.
 */
return new class extends Migration
{
    public function up(): void
    {
        // 17. BLOG CATEGORIES — tag filter tabs.
        Schema::create('blog_categories', function (Blueprint $table) {
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

        // 18. BLOGS — listing card + full detail page.
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->string('slug', 300)->unique();

            $table->string('title_en', 300);
            $table->string('title_fr', 300)->nullable();
            $table->string('title_ar', 300)->nullable();
            $table->text('excerpt_en')->nullable()->comment('Short description on listing cards');
            $table->text('excerpt_fr')->nullable();
            $table->text('excerpt_ar')->nullable();
            $table->longText('body_en')->nullable()->comment('Full HTML/Markdown article body');
            $table->longText('body_fr')->nullable();
            $table->longText('body_ar')->nullable();

            $table->string('cover_image_url', 500)->nullable();

            $table->unsignedTinyInteger('read_time_minutes')->nullable();
            $table->unsignedInteger('views')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->dateTime('published_at')->nullable();
            $table->timestamps();

            $table->index('published_at', 'idx_blog_published');
            $table->index(['is_active', 'is_featured'], 'idx_blog_active_featured');
        });

        // 19. BLOG ↔ CATEGORY — many-to-many.
        Schema::create('blog_category_map', function (Blueprint $table) {
            $table->foreignId('blog_id')->constrained('blogs')
                ->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('category_id')->constrained('blog_categories')
                ->cascadeOnDelete()->cascadeOnUpdate();

            $table->primary(['blog_id', 'category_id']);
        });

        // 20. BLOG TABLE OF CONTENTS — left-sidebar anchors.
        Schema::create('blog_toc', function (Blueprint $table) {
            $table->id();
            $table->foreignId('blog_id')->constrained('blogs')
                ->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('anchor', 150);                        // href="#introduction"
            $table->string('label_en', 200);
            $table->string('label_fr', 200)->nullable();
            $table->string('label_ar', 200)->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });

        // 21. RELATED ARTICLES — explicit editorial picks (self-referencing M2M).
        Schema::create('blog_related', function (Blueprint $table) {
            $table->foreignId('blog_id')->constrained('blogs')
                ->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('related_id')->constrained('blogs')
                ->cascadeOnDelete()->cascadeOnUpdate();
            $table->unsignedSmallInteger('sort_order')->default(0);

            $table->primary(['blog_id', 'related_id']);
        });

        // 22. BLOGS SECTION CONFIG — landing "Latest Blogs" + listing hero (singleton).
        Schema::create('blogs_section', function (Blueprint $table) {
            $table->id();
            $table->string('section_badge_en', 80)->default('> BLOGS');
            $table->string('section_badge_fr', 80)->default('> ARTICLES');
            $table->string('section_badge_ar', 80)->default('> المقالات');
            $table->string('heading_part1_en', 160)->default('Latest Blogs');
            $table->string('heading_part1_fr', 160)->default('Derniers Articles');
            $table->string('heading_part1_ar', 160)->default('أحدث المقالات');

            // Listing page hero
            $table->string('listing_badge_en', 80)->default('> MY BLOGS');
            $table->string('listing_badge_fr', 80)->default('> MES ARTICLES');
            $table->string('listing_badge_ar', 80)->default('> مقالاتي');
            $table->string('listing_title_part1_en', 160)->default('Tech Insights');
            $table->string('listing_title_part1_fr', 160)->default('Aperçus Tech');
            $table->string('listing_title_part1_ar', 160)->default('رؤى تقنية');
            $table->string('listing_title_part2_en', 160)->default('Blogs & Tutorials.');
            $table->string('listing_title_part2_fr', 160)->default('Blogs et Tutoriels.');
            $table->string('listing_title_part2_ar', 160)->default('مدونات ودروس.');
            $table->string('listing_subtitle_en', 500)->nullable();
            $table->string('listing_subtitle_fr', 500)->nullable();
            $table->string('listing_subtitle_ar', 500)->nullable();

            // CTA
            $table->string('cta_label_en', 80)->default('View All Blogs');
            $table->string('cta_label_fr', 80)->default('Voir tous les articles');
            $table->string('cta_label_ar', 80)->default('عرض كل المقالات');

            $table->timestamps();
        });

        // NOTE: We intentionally do NOT add a CHECK (blog_id <> related_id) here.
        // MySQL 8 forbids using a column in a CHECK constraint when that column
        // is part of a foreign key with a referential action (error 3823), and
        // the ON DELETE/UPDATE CASCADE behaviour is more valuable. Prevent an
        // article relating to itself in the application layer (model/request).
    }

    public function down(): void
    {
        Schema::dropIfExists('blogs_section');
        Schema::dropIfExists('blog_related');
        Schema::dropIfExists('blog_toc');
        Schema::dropIfExists('blog_category_map');
        Schema::dropIfExists('blogs');
        Schema::dropIfExists('blog_categories');
    }
};

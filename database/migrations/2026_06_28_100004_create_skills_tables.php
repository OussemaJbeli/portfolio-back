<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Skills section: technology icons (also reused as project tech badges),
 * skill-category progress bars, and the section heading block.
 */
return new class extends Migration
{
    public function up(): void
    {
        // 8. TECHNOLOGIES — tech icons / stack badges (Vue, Laravel, Docker…).
        Schema::create('technologies', function (Blueprint $table) {
            $table->id();
            $table->string('name', 80)->unique();                 // "Vue.js", "Laravel"
            $table->string('icon_url', 500)->nullable();
            $table->string('icon_class', 100)->nullable();        // devicon class
            $table->string('color', 7)->nullable();               // hex e.g. "#42B883"
            $table->timestamps();
        });

        // 7. SKILL CATEGORIES — progress bars ("Frontend Development 90%").
        Schema::create('skill_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name_en', 120);
            $table->string('name_fr', 120)->nullable();
            $table->string('name_ar', 120)->nullable();
            $table->unsignedTinyInteger('percentage')->default(0)->comment('0-100');
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['is_active', 'sort_order']);
        });

        // 9. SKILLS SECTION CONFIG — "My Skills" heading (singleton).
        Schema::create('skills_section', function (Blueprint $table) {
            $table->id();
            $table->string('section_badge_en', 80)->default('> SKILLS');
            $table->string('section_badge_fr', 80)->default('> COMPÉTENCES');
            $table->string('section_badge_ar', 80)->default('> المهارات');
            $table->string('heading_en', 160)->default('My Skills');
            $table->string('heading_fr', 160)->default('Mes compétences');
            $table->string('heading_ar', 160)->default('مهاراتي');
            $table->timestamps();
        });

        // Guard the percentage range at the DB level (MySQL 8 / Postgres support CHECK).
        if (in_array(DB::getDriverName(), ['mysql', 'pgsql'], true)) {
            DB::statement(
                'ALTER TABLE skill_categories ADD CONSTRAINT chk_skill_percentage CHECK (percentage BETWEEN 0 AND 100)'
            );
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('skills_section');
        Schema::dropIfExists('skill_categories');
        Schema::dropIfExists('technologies');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * "About Me" section: the singleton content block plus its bullet list.
 */
return new class extends Migration
{
    public function up(): void
    {
        // 5. ABOUT — bio, personal info card (singleton).
        Schema::create('about', function (Blueprint $table) {
            $table->id();

            // Section heading + badge
            $table->string('section_badge_en', 80)->default('> ABOUT ME');
            $table->string('section_badge_fr', 80)->default('> À PROPOS');
            $table->string('section_badge_ar', 80)->default('> عني');
            $table->string('heading_en', 160)->default('About Me');
            $table->string('heading_fr', 160)->default('À propos de moi');
            $table->string('heading_ar', 160)->default('عني');

            // Main bio paragraph
            $table->text('bio_en')->nullable();
            $table->text('bio_fr')->nullable();
            $table->text('bio_ar')->nullable();

            $table->string('photo_url', 500)->nullable();

            // Info card
            $table->string('display_name', 120)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('location_en', 120)->nullable();
            $table->string('location_fr', 120)->nullable();
            $table->string('location_ar', 120)->nullable();
            $table->string('availability_en', 120)->default('Freelance / Full-time');
            $table->string('availability_fr', 120)->default('Freelance / Temps plein');
            $table->string('availability_ar', 120)->default('عمل حر / دوام كامل');

            // CTA button
            $table->string('cta_label_en', 80)->default("Let's Talk");
            $table->string('cta_label_fr', 80)->default('Contactez-moi');
            $table->string('cta_label_ar', 80)->default('تواصل معي');
            $table->string('cta_url', 500)->nullable();

            $table->timestamps();
        });

        // 6. ABOUT BULLET POINTS — "3+ Years experience", etc.
        Schema::create('about_bullets', function (Blueprint $table) {
            $table->id();
            $table->string('icon_class', 100)->nullable();
            $table->string('text_en', 255);
            $table->string('text_fr', 255)->nullable();
            $table->string('text_ar', 255)->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['is_active', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('about_bullets');
        Schema::dropIfExists('about');
    }
};

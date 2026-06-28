<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Site-wide configuration and navigation.
 *
 * `site_settings` is a singleton (single row) holding global config:
 * branding, theme/language defaults, SEO meta and footer copy.
 */
return new class extends Migration
{
    public function up(): void
    {
        // 1. SITE SETTINGS — global config (logo, favicon, theme defaults, SEO).
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('logo_text', 10)->default('OJ.');      // top-left brand mark
            $table->string('favicon_url', 500)->nullable();
            $table->string('cv_url', 500)->nullable();            // "Download CV" target
            $table->enum('theme_default', ['dark', 'light'])->default('dark');
            $table->enum('lang_default', ['ar', 'fr', 'en'])->default('en');

            // SEO meta (per language)
            $table->string('meta_title_en', 160)->nullable();
            $table->string('meta_title_fr', 160)->nullable();
            $table->string('meta_title_ar', 160)->nullable();
            $table->string('meta_description_en', 320)->nullable();
            $table->string('meta_description_fr', 320)->nullable();
            $table->string('meta_description_ar', 320)->nullable();

            // Footer copy (per language)
            $table->string('footer_copy_en', 255)->default('© 2025 All rights reserved.');
            $table->string('footer_copy_fr', 255)->nullable();
            $table->string('footer_copy_ar', 255)->nullable();

            $table->timestamps();
        });

        // 26. NAV MENU ITEMS — navbar labels (i18n).
        Schema::create('nav_items', function (Blueprint $table) {
            $table->id();
            $table->string('route_key', 50)->unique();            // 'home','about','projects'…
            $table->string('href', 200);                          // '#home', '/projects'
            $table->string('label_en', 80);
            $table->string('label_fr', 80)->nullable();
            $table->string('label_ar', 80)->nullable();
            $table->string('icon_class', 100)->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['is_active', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nav_items');
        Schema::dropIfExists('site_settings');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Landing-page hero, shared social links, and the counter "stats" badges.
 */
return new class extends Migration
{
    public function up(): void
    {
        // 2. HERO — landing page top fold (singleton).
        Schema::create('hero', function (Blueprint $table) {
            $table->id();

            // Role badge  e.g. "> FULL-STACK DEVELOPER"
            $table->string('badge_en', 100)->nullable();
            $table->string('badge_fr', 100)->nullable();
            $table->string('badge_ar', 100)->nullable();

            // Greeting line  e.g. "Hello, I'm"
            $table->string('greeting_en', 100)->nullable();
            $table->string('greeting_fr', 100)->nullable();
            $table->string('greeting_ar', 100)->nullable();

            $table->string('full_name', 120);

            // Animated typewriter strings (JSON array per language)
            $table->json('typewriter_en')->nullable()->comment('["I build modern...", "I design..."]');
            $table->json('typewriter_fr')->nullable();
            $table->json('typewriter_ar')->nullable();

            // Tagline under the name
            $table->string('tagline_en', 500)->nullable();
            $table->string('tagline_fr', 500)->nullable();
            $table->string('tagline_ar', 500)->nullable();

            $table->string('photo_url', 500)->nullable();

            // CTA buttons
            $table->string('cta_primary_label_en', 80)->default('Download CV');
            $table->string('cta_primary_label_fr', 80)->default('Télécharger CV');
            $table->string('cta_primary_label_ar', 80)->default('تحميل السيرة الذاتية');
            $table->string('cta_primary_url', 500)->nullable();
            $table->string('cta_secondary_label_en', 80)->default('View My Works');
            $table->string('cta_secondary_label_fr', 80)->default('Voir mes travaux');
            $table->string('cta_secondary_label_ar', 80)->default('عرض أعمالي');
            $table->string('cta_secondary_url', 500)->nullable();

            // Floating code badge  e.g. "</>"
            $table->string('code_badge', 20)->default('</>');

            $table->timestamps();
        });

        // 3. SOCIAL LINKS — shared across hero, about, footer, blog author card.
        Schema::create('social_links', function (Blueprint $table) {
            $table->id();
            $table->string('platform', 50);                       // 'linkedin','github'…
            $table->string('url', 500);
            $table->string('icon_class', 100)->nullable();        // 'fab fa-linkedin' / SVG key
            $table->set('display_in', ['hero', 'about', 'footer', 'blog_author'])
                ->default('hero,footer');
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['is_active', 'sort_order']);
        });

        // 4. STATS — counter badges ("50+ Projects", "30+ Clients"…).
        Schema::create('stats', function (Blueprint $table) {
            $table->id();
            $table->string('value', 20);                          // "50+", "100%"
            $table->string('icon_class', 100)->nullable();
            $table->string('label_en', 100);
            $table->string('label_fr', 100)->nullable();
            $table->string('label_ar', 100)->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['is_active', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stats');
        Schema::dropIfExists('social_links');
        Schema::dropIfExists('hero');
    }
};

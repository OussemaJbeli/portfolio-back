<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Fills the remaining gaps against the master profile:
 *   • journey_tracks → employment_type + location (so work history captures
 *     internships vs full-time and where each role was),
 *   • about → birthdate (age), a long-form summary, and a structured "open to",
 *   • projects → project_type (freelance / professional / academic / personal).
 */
return new class extends Migration
{
    public function up(): void
    {
        // Work / education history lives on journey_tracks — enrich it.
        Schema::table('journey_tracks', function (Blueprint $table) {
            $table->enum('employment_type', ['full_time', 'part_time', 'internship', 'freelance', 'contract'])
                ->nullable()->after('type');
            $table->string('location_en', 160)->nullable()->after('org_ar');
            $table->string('location_fr', 160)->nullable()->after('location_en');
            $table->string('location_ar', 160)->nullable()->after('location_fr');
        });

        Schema::table('about', function (Blueprint $table) {
            $table->date('birthdate')->nullable()->after('email');
            // Longer CV / LinkedIn summary, distinct from the short hero-side bio.
            $table->text('summary_en')->nullable()->after('bio_ar');
            $table->text('summary_fr')->nullable()->after('summary_en');
            $table->text('summary_ar')->nullable()->after('summary_fr');
            // "Open to" roles / freelance / internships.
            $table->string('open_to_en', 300)->nullable()->after('availability_ar');
            $table->string('open_to_fr', 300)->nullable()->after('open_to_en');
            $table->string('open_to_ar', 300)->nullable()->after('open_to_fr');
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->enum('project_type', ['freelance', 'professional', 'academic', 'personal'])
                ->nullable()->after('category_id');
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('project_type');
        });

        Schema::table('about', function (Blueprint $table) {
            $table->dropColumn([
                'birthdate',
                'summary_en', 'summary_fr', 'summary_ar',
                'open_to_en', 'open_to_fr', 'open_to_ar',
            ]);
        });

        Schema::table('journey_tracks', function (Blueprint $table) {
            $table->dropColumn(['employment_type', 'location_en', 'location_fr', 'location_ar']);
        });
    }
};

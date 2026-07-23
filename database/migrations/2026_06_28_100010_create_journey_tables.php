<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * The Journey ("git log --graph --all") section: the singleton section config,
 * the career branches (tracks), the commits on them (milestones), and the
 * milestone↔technology pivot. Mirrors the project tables' conventions.
 */
return new class extends Migration
{
    public function up(): void
    {
        // 17. JOURNEY SECTION CONFIG — heading + ghost "next" commit (singleton).
        Schema::create('journey_section', function (Blueprint $table) {
            $table->id();
            $table->string('section_badge_en', 80)->default('> GIT LOG --ALL');
            $table->string('section_badge_fr', 80)->default('> HISTORIQUE GIT');
            $table->string('section_badge_ar', 80)->default('> سجل المسيرة');
            $table->string('heading_en', 160)->default('My Journey');
            $table->string('heading_fr', 160)->default('Mon Parcours');
            $table->string('heading_ar', 160)->default('مسيرتي');
            $table->string('subheading_en', 500)->nullable();
            $table->string('subheading_fr', 500)->nullable();
            $table->string('subheading_ar', 500)->nullable();
            // The blinking ghost-commit at the HEAD / now-line.
            $table->string('next_label_en', 160)->default('next: AI Platform Engineer');
            $table->string('next_label_fr', 160)->default('next: AI Platform Engineer');
            $table->string('next_label_ar', 160)->default('next: مهندس منصّات ذكاء اصطناعي');
            $table->timestamps();
        });

        // 18. JOURNEY TRACKS — the branches (main / edu / work / freelance / self).
        Schema::create('journey_tracks', function (Blueprint $table) {
            $table->id();
            $table->string('slug', 80)->unique();
            $table->string('branch_name', 120); // 'edu/software-engineering'
            $table->enum('type', ['main', 'education', 'work', 'freelance', 'self']);
            $table->string('color', 7)->nullable(); // override; else type default (frontend)
            $table->string('icon_class', 100)->nullable();
            $table->string('label_en', 160);
            $table->string('label_fr', 160)->nullable();
            $table->string('label_ar', 160)->nullable();
            $table->string('org_en', 160)->nullable();
            $table->string('org_fr', 160)->nullable();
            $table->string('org_ar', 160)->nullable();
            $table->date('started_at');
            $table->date('ended_at')->nullable(); // NULL = open branch
            $table->unsignedTinyInteger('lane_index')->default(0);
            // Branch this one merges back into (usually main).
            $table->foreignId('merges_into_id')->nullable()
                ->constrained('journey_tracks')
                ->nullOnDelete()
                ->cascadeOnUpdate();
            $table->date('merged_at')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['is_active', 'sort_order']);
        });

        // 19. JOURNEY MILESTONES — the commits (and tag/merge/head nodes).
        Schema::create('journey_milestones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('track_id')->constrained('journey_tracks')
                ->cascadeOnDelete()->cascadeOnUpdate();
            $table->enum('kind', ['commit', 'tag', 'merge', 'head'])->default('commit');
            $table->char('commit_hash', 7); // generated: substr(sha1(slug|title_en), 0, 7)
            $table->string('title_en', 200);
            $table->string('title_fr', 200)->nullable();
            $table->string('title_ar', 200)->nullable();
            $table->text('body_en')->nullable();
            $table->text('body_fr')->nullable();
            $table->text('body_ar')->nullable();
            $table->string('tag_label', 60)->nullable(); // 'v1.0-bachelor' (kind=tag)
            $table->date('happened_at');
            // ★ the killer column: a commit can open a real project card.
            $table->foreignId('project_id')->nullable()
                ->constrained('projects')
                ->nullOnDelete()
                ->cascadeOnUpdate();
            $table->string('link_url', 500)->nullable();
            $table->boolean('is_highlight')->default(false);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['track_id', 'is_active', 'sort_order']);
            $table->index('happened_at');
        });

        // 20. JOURNEY MILESTONE ↔ TECHNOLOGY — tech chips on a commit (reuse technologies).
        Schema::create('journey_milestone_technologies', function (Blueprint $table) {
            $table->foreignId('milestone_id')->constrained('journey_milestones')
                ->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('technology_id')->constrained('technologies')
                ->cascadeOnDelete()->cascadeOnUpdate();
            $table->unsignedSmallInteger('sort_order')->default(0);

            $table->primary(['milestone_id', 'technology_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('journey_milestone_technologies');
        Schema::dropIfExists('journey_milestones');
        Schema::dropIfExists('journey_tracks');
        Schema::dropIfExists('journey_section');
    }
};

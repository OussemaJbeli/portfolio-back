<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Named skill buckets for the flat `technologies` list — e.g. "Programming
 * Languages", "Frameworks", "Databases", "DevOps & Cloud", "AI / Data Science".
 * Adds a nullable `group_id` FK + a `proficiency` marker to technologies so the
 * profile's grouped skills (and "core" highlights) can be represented.
 */
return new class extends Migration
{
    public function up(): void
    {
        // 29. TECHNOLOGY GROUPS — skill buckets.
        Schema::create('technology_groups', function (Blueprint $table) {
            $table->id();
            $table->string('slug', 80)->unique();
            $table->string('name_en', 120);
            $table->string('name_fr', 120)->nullable();
            $table->string('name_ar', 120)->nullable();
            $table->string('icon_class', 100)->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['is_active', 'sort_order']);
        });

        Schema::table('technologies', function (Blueprint $table) {
            $table->foreignId('group_id')->nullable()->after('id')
                ->constrained('technology_groups')
                ->nullOnDelete()
                ->cascadeOnUpdate();
            // How strong this skill is — lets a CV mark a few as "core".
            $table->enum('proficiency', ['core', 'proficient', 'familiar'])
                ->default('proficient')->after('is_featured');
            $table->unsignedSmallInteger('sort_order')->default(0)->after('proficiency');
        });
    }

    public function down(): void
    {
        Schema::table('technologies', function (Blueprint $table) {
            $table->dropConstrainedForeignId('group_id');
            $table->dropColumn(['proficiency', 'sort_order']);
        });

        Schema::dropIfExists('technology_groups');
    }
};

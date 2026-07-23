<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * CV/profile data that had no home before:
 *   • spoken languages (name + CEFR-ish level + note),
 *   • personal interests / hobbies.
 * Both follow the ordered + is_active collection convention.
 */
return new class extends Migration
{
    public function up(): void
    {
        // 27. LANGUAGES — spoken languages with proficiency (Arabic, French…).
        Schema::create('languages', function (Blueprint $table) {
            $table->id();
            $table->string('name_en', 80);
            $table->string('name_fr', 80)->nullable();
            $table->string('name_ar', 80)->nullable();
            // CEFR-ish proficiency; `native` sits above C2.
            $table->enum('level', ['native', 'c2', 'c1', 'b2', 'b1', 'a2', 'a1'])->default('b1');
            $table->string('note_en', 160)->nullable();
            $table->string('note_fr', 160)->nullable();
            $table->string('note_ar', 160)->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['is_active', 'sort_order']);
        });

        // 28. INTERESTS — hobbies / personal interests chips.
        Schema::create('interests', function (Blueprint $table) {
            $table->id();
            $table->string('name_en', 80);
            $table->string('name_fr', 80)->nullable();
            $table->string('name_ar', 80)->nullable();
            $table->string('icon_class', 100)->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['is_active', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('interests');
        Schema::dropIfExists('languages');
    }
};

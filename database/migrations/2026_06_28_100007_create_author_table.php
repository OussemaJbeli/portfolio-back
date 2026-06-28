<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * 23. AUTHOR — "About the Author" card on blog detail (singleton, kept as a
 * table for future multi-author flexibility).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('author', function (Blueprint $table) {
            $table->id();
            $table->string('full_name', 120);
            $table->string('photo_url', 500)->nullable();
            $table->string('role_en', 120)->nullable();
            $table->string('role_fr', 120)->nullable();
            $table->string('role_ar', 120)->nullable();
            $table->text('bio_en')->nullable();
            $table->text('bio_fr')->nullable();
            $table->text('bio_ar')->nullable();
            $table->string('profile_url', 500)->nullable();       // "View Profile →"
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('author');
    }
};

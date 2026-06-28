<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * 27. ADMIN USERS — CMS back-office accounts.
 *
 * Kept separate from the framework `users` table so site visitors / API
 * consumers and back-office editors never share a table.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admin_users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 120);
            $table->string('email', 255)->unique();
            $table->string('password_hash', 255);
            $table->enum('role', ['superadmin', 'editor'])->default('editor');
            $table->dateTime('last_login_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admin_users');
    }
};

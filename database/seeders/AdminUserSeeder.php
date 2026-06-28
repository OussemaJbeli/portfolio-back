<?php

namespace Database\Seeders;

use App\Models\AdminUser;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Seeds the initial CMS back-office account in `admin_users`.
 *
 * Credentials default to admin@oj.tn / devops123 but can be overridden with
 * ADMIN_NAME / ADMIN_EMAIL / ADMIN_PASSWORD in .env.
 *
 * Idempotent: uses firstOrCreate, so re-running won't reset an existing
 * admin's password.
 */
class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $name = env('ADMIN_NAME', 'Admin');
        $email = env('ADMIN_EMAIL', 'admin@oj.tn');
        $password = env('ADMIN_PASSWORD', 'devops123');

        $admin = AdminUser::firstOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'password_hash' => Hash::make($password),
                'role' => 'superadmin',
            ],
        );

        if ($admin->wasRecentlyCreated) {
            $this->command->info("✓ Admin created — {$email} / {$password}");
        } else {
            $this->command->warn("• Admin already exists — {$email} (password left unchanged)");
        }
    }
}

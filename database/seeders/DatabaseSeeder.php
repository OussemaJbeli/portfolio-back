<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PortfolioSeeder::class,
            ProfileSeeder::class, // after technologies exist (groups them + adds languages/interests)
            JourneySeeder::class, // after projects exist (freelance commits link to them)
            AdminUserSeeder::class,
        ]);
    }
}

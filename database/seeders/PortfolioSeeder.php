<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * Orchestrates the full portfolio CMS content seed.
 *
 * Split into focused, idempotent domain seeders. Order matters:
 * technologies (HomeSeeder) must exist before projects link to them.
 *
 * Safe to run repeatedly — every seeder keys on a natural unique column
 * (slug / route_key / name / id) via updateOrInsert / updateOrCreate / sync.
 */
class PortfolioSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            SiteSeeder::class,     // site_settings, nav_items, social_links
            HomeSeeder::class,     // hero, stats, about, about_bullets, skills, technologies
            ProjectSeeder::class,  // projects_section, categories, projects (+ children & tech)
            BlogSeeder::class,     // author, blogs_section, categories, posts (+ toc/related/map)
            ContactSeeder::class,  // contact_section, sample inbox messages
        ]);
    }
}

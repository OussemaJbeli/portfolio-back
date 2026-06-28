<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Seeds the portfolio CMS with its baseline content:
 *  - navigation items and stat counters (from the original schema seed)
 *  - one editable row for each singleton "section config" table
 *
 * Idempotent: safe to run repeatedly (uses updateOrInsert).
 */
class PortfolioSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        // ── Navigation items ──────────────────────────────────────────────
        $nav = [
            ['home',     '#home',     'Home',     'Accueil',     'الرئيسية', 1],
            ['about',    '#about',    'About',    'À propos',    'عني',      2],
            ['projects', '/projects', 'Projects', 'Projets',     'المشاريع', 3],
            ['skills',   '#skills',   'Skills',   'Compétences', 'المهارات', 4],
            ['blogs',    '/blogs',    'Blogs',    'Articles',    'المقالات', 5],
            ['contact',  '#contact',  'Contact',  'Contact',     'التواصل',  6],
        ];
        foreach ($nav as [$key, $href, $en, $fr, $ar, $order]) {
            DB::table('nav_items')->updateOrInsert(
                ['route_key' => $key],
                [
                    'href' => $href, 'label_en' => $en, 'label_fr' => $fr, 'label_ar' => $ar,
                    'sort_order' => $order, 'is_active' => true, 'updated_at' => $now, 'created_at' => $now,
                ]
            );
        }

        // ── Stat counters ─────────────────────────────────────────────────
        $stats = [
            ['50+',  'icon-rocket', 'Projects Completed', 'Projets réalisés',   'مشاريع منجزة', 1],
            ['30+',  'icon-smile',  'Happy Clients',      'Clients satisfaits', 'عملاء سعداء',  2],
            ['3+',   'icon-award',  'Years Experience',   "Ans d'expérience",   'سنوات خبرة',   3],
            ['100%', 'icon-code',   'Commitment',         'Engagement',         'الالتزام',     4],
        ];
        foreach ($stats as [$value, $icon, $en, $fr, $ar, $order]) {
            DB::table('stats')->updateOrInsert(
                ['label_en' => $en],
                [
                    'value' => $value, 'icon_class' => $icon, 'label_fr' => $fr, 'label_ar' => $ar,
                    'sort_order' => $order, 'is_active' => true, 'updated_at' => $now, 'created_at' => $now,
                ]
            );
        }

        // ── Singleton section-config rows (defaults fill the rest) ─────────
        DB::table('site_settings')->updateOrInsert(['id' => 1], ['updated_at' => $now, 'created_at' => $now]);
        DB::table('about')->updateOrInsert(['id' => 1], ['updated_at' => $now, 'created_at' => $now]);
        DB::table('skills_section')->updateOrInsert(['id' => 1], ['updated_at' => $now, 'created_at' => $now]);
        DB::table('projects_section')->updateOrInsert(['id' => 1], ['updated_at' => $now, 'created_at' => $now]);
        DB::table('blogs_section')->updateOrInsert(['id' => 1], ['updated_at' => $now, 'created_at' => $now]);
        DB::table('contact_section')->updateOrInsert(['id' => 1], ['updated_at' => $now, 'created_at' => $now]);

        DB::table('hero')->updateOrInsert(
            ['id' => 1],
            ['full_name' => 'Oussema Jbeli', 'updated_at' => $now, 'created_at' => $now]
        );
        DB::table('author')->updateOrInsert(
            ['id' => 1],
            [
                'full_name' => 'Oussema Jbeli',
                'role_en' => 'Full-Stack Developer',
                'updated_at' => $now, 'created_at' => $now,
            ]
        );
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Global / layout content: site settings (singleton) and social links.
 * Idempotent — keyed upserts.
 */
class SiteSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        DB::table('site_settings')->updateOrInsert(
            ['id' => 1],
            [
                'logo_text' => 'OJ.',
                'favicon_url' => null,
                'cv_url' => 'https://example.com/oussema-jbeli-cv.pdf',
                'theme_default' => 'dark',
                'lang_default' => 'en',
                'meta_title_en' => 'Oussema Jbeli — Software & AI/Data Science Engineer',
                'meta_title_fr' => 'Oussema Jbeli — Ingénieur logiciel & IA/Data Science',
                'meta_title_ar' => 'أسامة الجبلي — مهندس برمجيات وذكاء اصطناعي/علوم بيانات',
                'meta_description_en' => 'DevOps, Cloud (AWS) and full-stack engineer building and shipping real products with Laravel, Vue and TypeScript.',
                'meta_description_fr' => "Ingénieur DevOps, Cloud (AWS) et full-stack qui conçoit et livre de vrais produits avec Laravel, Vue et TypeScript.",
                'meta_description_ar' => 'مهندس DevOps وسحابة (AWS) وfull-stack يبني ويطلق منتجات حقيقية باستخدام Laravel وVue وTypeScript.',
                'footer_copy_en' => '© 2025 Oussema Jbeli. All rights reserved.',
                'footer_copy_fr' => '© 2025 Oussema Jbeli. Tous droits réservés.',
                'footer_copy_ar' => '© 2025 أسامة الجبلي. جميع الحقوق محفوظة.',
                'updated_at' => $now,
                'created_at' => $now,
            ]
        );

        // ── Navigation ────────────────────────────────────────────────────
        $nav = [
            ['home', '#home', 'Home', 'Accueil', 'الرئيسية', 'fas fa-house', 1],
            ['about', '#about', 'About', 'À propos', 'عني', 'fas fa-user', 2],
            ['projects', '/projects', 'Projects', 'Projets', 'المشاريع', 'fas fa-folder', 3],
            ['skills', '#skills', 'Skills', 'Compétences', 'المهارات', 'fas fa-bars-progress', 4],
            ['blogs', '/blogs', 'Blogs', 'Articles', 'المقالات', 'fas fa-newspaper', 5],
            ['contact', '#contact', 'Contact', 'Contact', 'التواصل', 'fas fa-envelope', 6],
        ];
        foreach ($nav as [$key, $href, $en, $fr, $ar, $icon, $order]) {
            DB::table('nav_items')->updateOrInsert(
                ['route_key' => $key],
                [
                    'href' => $href, 'label_en' => $en, 'label_fr' => $fr, 'label_ar' => $ar,
                    'icon_class' => $icon, 'sort_order' => $order, 'is_active' => true,
                    'updated_at' => $now, 'created_at' => $now,
                ]
            );
        }

        $socials = [
            ['linkedin', 'https://www.linkedin.com/in/jbeli-oussema-235787253', 'fab fa-linkedin', 'hero,about,footer', 1, true],
            ['github', 'https://github.com/OussemaJbeli', 'fab fa-github', 'hero,about,footer', 2, true],
        ];

        foreach ($socials as [$platform, $url, $icon, $displayIn, $order, $active]) {
            DB::table('social_links')->updateOrInsert(
                ['platform' => $platform],
                [
                    'url' => $url,
                    'icon_class' => $icon,
                    'display_in' => $displayIn,
                    'sort_order' => $order,
                    'is_active' => $active,
                    'updated_at' => $now,
                    'created_at' => $now,
                ]
            );
        }
    }
}

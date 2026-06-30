<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Blog: author card, section config, tag categories and posts with their
 * table of contents, category map and editorial "related articles".
 *
 * Idempotent: parents upserted by slug; pivots/children cleared per-post.
 */
class BlogSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        // ── Author ────────────────────────────────────────────────────────
        DB::table('author')->updateOrInsert(
            ['id' => 1],
            [
                'full_name' => 'Oussema Jbeli',
                'photo_url' => 'https://i.pravatar.cc/600?img=12',
                'role_en' => 'Full-Stack Developer',
                'role_fr' => 'Développeur Full-Stack',
                'role_ar' => 'مطوّر full-stack',
                'bio_en' => 'Full-stack developer writing about Laravel, Vue and the craft of shipping web products.',
                'bio_fr' => "Développeur full-stack qui écrit sur Laravel, Vue et l'art de livrer des produits web.",
                'bio_ar' => 'مطوّر full-stack يكتب عن Laravel وVue وفنّ إطلاق منتجات الويب.',
                'profile_url' => '#about',
                'updated_at' => $now, 'created_at' => $now,
            ]
        );

        // ── Section config (subtitles; defaults cover the rest) ────────────
        DB::table('blogs_section')->updateOrInsert(
            ['id' => 1],
            [
                'listing_subtitle_en' => 'Notes on building modern web apps — Laravel, Vue, DevOps and lessons learned.',
                'listing_subtitle_fr' => 'Notes sur la création d\'applications web modernes — Laravel, Vue, DevOps et leçons apprises.',
                'listing_subtitle_ar' => 'ملاحظات حول بناء تطبيقات ويب حديثة — Laravel وVue وDevOps ودروس مستفادة.',
                'updated_at' => $now, 'created_at' => $now,
            ]
        );

        // ── Categories ──────────────────────────────────────────────────��─
        $categories = [
            ['tutorials', 'Tutorials', 'Tutoriels', 'دروس', 1],
            ['web-dev', 'Web Development', 'Développement Web', 'تطوير الويب', 2],
            ['devops', 'DevOps', 'DevOps', 'DevOps', 3],
            ['career', 'Career', 'Carrière', 'مسيرة مهنية', 4],
        ];
        foreach ($categories as [$slug, $en, $fr, $ar, $order]) {
            DB::table('blog_categories')->updateOrInsert(
                ['slug' => $slug],
                ['name_en' => $en, 'name_fr' => $fr, 'name_ar' => $ar, 'sort_order' => $order, 'is_active' => true, 'updated_at' => $now, 'created_at' => $now]
            );
        }
        $catId = fn (string $slug) => DB::table('blog_categories')->where('slug', $slug)->value('id');

        // ── Posts ───────────────────────────────────────────────────────��─
        $posts = [
            [
                'slug' => 'multilingual-laravel-vue-cms',
                'is_featured' => true,
                'read_time' => 8,
                'published_at' => '2025-03-25 09:00:00',
                'cover' => 'https://picsum.photos/seed/blog-cms/1200/630',
                'title_en' => 'Building a Trilingual CMS with Laravel & Vue',
                'title_fr' => 'Construire un CMS trilingue avec Laravel & Vue',
                'title_ar' => 'بناء نظام إدارة محتوى ثلاثي اللغات باستخدام Laravel وVue',
                'excerpt_en' => 'How I designed an Arabic/French/English content model and a one-input-per-field editor.',
                'excerpt_fr' => 'Comment j\'ai conçu un modèle de contenu arabe/français/anglais et un éditeur à champ unique.',
                'excerpt_ar' => 'كيف صمّمت نموذج محتوى عربي/فرنسي/إنجليزي ومحرّرًا بحقل واحد لكل لغة.',
                'body_en' => '<h2 id="intro">Introduction</h2><p>Supporting three languages cleanly is mostly a data-modelling problem. This post walks through the approach.</p><h2 id="schema">The schema</h2><p>Each translatable field becomes three columns: <code>_en</code>, <code>_fr</code> and <code>_ar</code>. English is required, the rest are nullable.</p><h2 id="editor">The editor</h2><p>Instead of three inputs, one input with a small language switcher keeps forms compact and fast to fill.</p>',
                'body_fr' => '<h2 id="intro">Introduction</h2><p>Gérer proprement trois langues est avant tout un problème de modélisation des données.</p><h2 id="schema">Le schéma</h2><p>Chaque champ traduisible devient trois colonnes : <code>_en</code>, <code>_fr</code> et <code>_ar</code>.</p><h2 id="editor">L\'éditeur</h2><p>Un seul champ avec un sélecteur de langue garde les formulaires compacts.</p>',
                'body_ar' => '<h2 id="intro">مقدمة</h2><p>دعم ثلاث لغات بشكل نظيف هو في الأساس مسألة نمذجة بيانات.</p><h2 id="schema">المخطط</h2><p>كل حقل قابل للترجمة يصبح ثلاثة أعمدة: <code>_en</code> و<code>_fr</code> و<code>_ar</code>.</p><h2 id="editor">المحرّر</h2><p>حقل واحد مع مبدّل لغة يبقي النماذج مدمجة وسريعة.</p>',
                'categories' => ['web-dev', 'tutorials'],
                'toc' => [
                    ['intro', 'Introduction', 'Introduction', 'مقدمة'],
                    ['schema', 'The schema', 'Le schéma', 'المخطط'],
                    ['editor', 'The editor', 'L\'éditeur', 'المحرّر'],
                ],
                'related' => ['clean-api-design-laravel', 'docker-for-laravel-devs'],
            ],
            [
                'slug' => 'clean-api-design-laravel',
                'is_featured' => true,
                'read_time' => 6,
                'published_at' => '2025-02-12 10:30:00',
                'cover' => 'https://picsum.photos/seed/blog-api/1200/630',
                'title_en' => 'Clean REST API Design in Laravel',
                'title_fr' => 'Conception d\'API REST propre avec Laravel',
                'title_ar' => 'تصميم واجهة REST نظيفة في Laravel',
                'excerpt_en' => 'Resource controllers, form requests and consistent JSON — patterns that scale.',
                'excerpt_fr' => 'Contrôleurs de ressources, form requests et JSON cohérent — des patterns qui passent à l\'échelle.',
                'excerpt_ar' => 'متحكّمات الموارد وform requests وJSON متّسق — أنماط قابلة للتوسّع.',
                'body_en' => '<h2 id="resources">Resource controllers</h2><p>Lean on <code>apiResource</code> routes and keep controllers thin.</p><h2 id="validation">Validation</h2><p>Centralise rules so create and update stay in sync.</p><h2 id="shape">Response shape</h2><p>Return predictable JSON and let detail endpoints embed their children.</p>',
                'body_fr' => '<h2 id="resources">Contrôleurs de ressources</h2><p>Appuyez-vous sur les routes <code>apiResource</code> et gardez les contrôleurs légers.</p><h2 id="validation">Validation</h2><p>Centralisez les règles pour que create et update restent synchronisés.</p><h2 id="shape">Forme des réponses</h2><p>Renvoyez un JSON prévisible.</p>',
                'body_ar' => '<h2 id="resources">متحكّمات الموارد</h2><p>اعتمد على مسارات <code>apiResource</code> وأبقِ المتحكّمات خفيفة.</p><h2 id="validation">التحقّق</h2><p>وحّد القواعد ليبقى الإنشاء والتحديث متزامنين.</p><h2 id="shape">شكل الاستجابة</h2><p>أعد JSON متوقّعًا.</p>',
                'categories' => ['web-dev'],
                'toc' => [
                    ['resources', 'Resource controllers', 'Contrôleurs de ressources', 'متحكّمات الموارد'],
                    ['validation', 'Validation', 'Validation', 'التحقّق'],
                    ['shape', 'Response shape', 'Forme des réponses', 'شكل الاستجابة'],
                ],
                'related' => ['multilingual-laravel-vue-cms'],
            ],
            [
                'slug' => 'docker-for-laravel-devs',
                'is_featured' => false,
                'read_time' => 7,
                'published_at' => '2025-01-08 08:00:00',
                'cover' => 'https://picsum.photos/seed/blog-docker/1200/630',
                'title_en' => 'Docker for Laravel Developers',
                'title_fr' => 'Docker pour les développeurs Laravel',
                'title_ar' => 'Docker لمطوّري Laravel',
                'excerpt_en' => 'A pragmatic local setup with PHP-FPM, Nginx, MySQL and Redis.',
                'excerpt_fr' => 'Une configuration locale pragmatique avec PHP-FPM, Nginx, MySQL et Redis.',
                'excerpt_ar' => 'إعداد محلّي عملي مع PHP-FPM وNginx وMySQL وRedis.',
                'body_en' => '<h2 id="why">Why Docker</h2><p>Reproducible environments end "works on my machine".</p><h2 id="compose">The compose file</h2><p>One service per concern: app, web, db, cache.</p><h2 id="tips">Tips</h2><p>Cache Composer layers and mount only what you need for speed.</p>',
                'body_fr' => '<h2 id="why">Pourquoi Docker</h2><p>Des environnements reproductibles mettent fin au « ça marche chez moi ».</p><h2 id="compose">Le fichier compose</h2><p>Un service par responsabilité : app, web, db, cache.</p><h2 id="tips">Astuces</h2><p>Mettez en cache les couches Composer.</p>',
                'body_ar' => '<h2 id="why">لماذا Docker</h2><p>البيئات القابلة للتكرار تنهي عبارة «يعمل على جهازي».</p><h2 id="compose">ملف compose</h2><p>خدمة لكل مسؤولية: التطبيق، الويب، قاعدة البيانات، التخزين المؤقت.</p><h2 id="tips">نصائح</h2><p>خزّن طبقات Composer مؤقتًا.</p>',
                'categories' => ['devops', 'tutorials'],
                'toc' => [
                    ['why', 'Why Docker', 'Pourquoi Docker', 'لماذا Docker'],
                    ['compose', 'The compose file', 'Le fichier compose', 'ملف compose'],
                    ['tips', 'Tips', 'Astuces', 'نصائح'],
                ],
                'related' => ['clean-api-design-laravel'],
            ],
            [
                'slug' => 'three-years-freelancing-lessons',
                'is_featured' => false,
                'read_time' => 5,
                'published_at' => '2024-11-20 12:00:00',
                'cover' => 'https://picsum.photos/seed/blog-career/1200/630',
                'title_en' => 'Three Years Freelancing: What I\'d Tell Myself',
                'title_fr' => 'Trois ans en freelance : ce que je me dirais',
                'title_ar' => 'ثلاث سنوات في العمل الحر: ما كنت سأقوله لنفسي',
                'excerpt_en' => 'Pricing, scope and communication — the non-code skills that mattered most.',
                'excerpt_fr' => 'Tarification, périmètre et communication — les compétences hors code qui comptent.',
                'excerpt_ar' => 'التسعير والنطاق والتواصل — المهارات غير البرمجية الأهم.',
                'body_en' => '<h2 id="pricing">Price the value</h2><p>Charge for outcomes, not hours, whenever you can.</p><h2 id="scope">Guard the scope</h2><p>Write it down; change requests are normal, surprises are not.</p><h2 id="comms">Over-communicate</h2><p>A short weekly update prevents most problems.</p>',
                'body_fr' => '<h2 id="pricing">Facturez la valeur</h2><p>Facturez les résultats, pas les heures, dès que possible.</p><h2 id="scope">Protégez le périmètre</h2><p>Écrivez-le ; les demandes de changement sont normales.</p><h2 id="comms">Sur-communiquez</h2><p>Un point hebdomadaire évite la plupart des problèmes.</p>',
                'body_ar' => '<h2 id="pricing">سعّر القيمة</h2><p>احتسب مقابل النتائج لا الساعات كلما أمكن.</p><h2 id="scope">احمِ النطاق</h2><p>دوّنه؛ طلبات التغيير طبيعية أمّا المفاجآت فلا.</p><h2 id="comms">تواصل بكثرة</h2><p>تحديث أسبوعي قصير يمنع معظم المشاكل.</p>',
                'categories' => ['career'],
                'toc' => [
                    ['pricing', 'Price the value', 'Facturez la valeur', 'سعّر القيمة'],
                    ['scope', 'Guard the scope', 'Protégez le périmètre', 'احمِ النطاق'],
                    ['comms', 'Over-communicate', 'Sur-communiquez', 'تواصل بكثرة'],
                ],
                'related' => ['multilingual-laravel-vue-cms'],
            ],
        ];

        // First pass: upsert posts + toc + category map.
        foreach ($posts as $b) {
            DB::table('blogs')->updateOrInsert(
                ['slug' => $b['slug']],
                [
                    'title_en' => $b['title_en'], 'title_fr' => $b['title_fr'], 'title_ar' => $b['title_ar'],
                    'excerpt_en' => $b['excerpt_en'], 'excerpt_fr' => $b['excerpt_fr'], 'excerpt_ar' => $b['excerpt_ar'],
                    'body_en' => $b['body_en'], 'body_fr' => $b['body_fr'], 'body_ar' => $b['body_ar'],
                    'cover_image_url' => $b['cover'],
                    'read_time_minutes' => $b['read_time'],
                    'is_featured' => $b['is_featured'],
                    'is_active' => true,
                    'published_at' => $b['published_at'],
                    'updated_at' => $now, 'created_at' => $now,
                ]
            );

            $blogId = DB::table('blogs')->where('slug', $b['slug'])->value('id');

            // Table of contents.
            DB::table('blog_toc')->where('blog_id', $blogId)->delete();
            foreach ($b['toc'] as $i => [$anchor, $en, $fr, $ar]) {
                DB::table('blog_toc')->insert([
                    'blog_id' => $blogId, 'anchor' => $anchor,
                    'label_en' => $en, 'label_fr' => $fr, 'label_ar' => $ar,
                    'sort_order' => $i + 1, 'updated_at' => $now, 'created_at' => $now,
                ]);
            }

            // Category map.
            DB::table('blog_category_map')->where('blog_id', $blogId)->delete();
            foreach ($b['categories'] as $slug) {
                if ($cid = $catId($slug)) {
                    DB::table('blog_category_map')->insert(['blog_id' => $blogId, 'category_id' => $cid]);
                }
            }
        }

        // Second pass: related articles (all posts now exist).
        foreach ($posts as $b) {
            $blogId = DB::table('blogs')->where('slug', $b['slug'])->value('id');
            DB::table('blog_related')->where('blog_id', $blogId)->delete();
            foreach ($b['related'] as $i => $relSlug) {
                $relId = DB::table('blogs')->where('slug', $relSlug)->value('id');
                if ($relId && $relId !== $blogId) {
                    DB::table('blog_related')->insert([
                        'blog_id' => $blogId, 'related_id' => $relId, 'sort_order' => $i + 1,
                    ]);
                }
            }
        }
    }
}

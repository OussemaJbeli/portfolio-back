<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Projects: real freelance + academic work from the master profile, their
 * categories, gallery, feature checklist, "what I did" role cards and tech pivot.
 *
 * Idempotent: parents are upserted by slug; children are cleared per-project
 * and re-inserted so re-running never duplicates. Images are placeholders —
 * swap them from the admin board.
 */
class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        // ── Categories ────────────────────────────────────────────────────
        $categories = [
            ['web-apps', 'Web Applications', 'Applications Web', 'تطبيقات الويب', 1],
            ['education', 'Education Platforms', 'Plateformes éducatives', 'منصّات تعليمية', 2],
            ['landing-pages', 'Landing Pages', 'Landing pages', 'صفحات هبوط', 3],
        ];
        foreach ($categories as [$slug, $en, $fr, $ar, $order]) {
            DB::table('project_categories')->updateOrInsert(
                ['slug' => $slug],
                ['name_en' => $en, 'name_fr' => $fr, 'name_ar' => $ar, 'sort_order' => $order, 'is_active' => true, 'updated_at' => $now, 'created_at' => $now]
            );
        }
        $catId = fn (string $slug) => DB::table('project_categories')->where('slug', $slug)->value('id');

        // ── Projects ──────────────────────────────────────────────────────
        $projects = [
            [
                'slug' => 'boonapp',
                'category' => 'web-apps',
                'project_type' => 'freelance',
                'is_featured' => true,
                'sort_order' => 1,
                'completed_date' => '2023-11-01',
                'title_en' => 'BoonApp', 'title_fr' => 'BoonApp', 'title_ar' => 'BoonApp',
                'subtitle_en' => 'Large real-estate platform (production)', 'subtitle_fr' => 'Grande plateforme immobilière (production)', 'subtitle_ar' => 'منصّة عقارية كبيرة (إنتاج)',
                'description_en' => 'A production real-estate platform with listings, search and agent dashboards, built full-stack.',
                'description_fr' => 'Une plateforme immobilière en production avec annonces, recherche et tableaux de bord agents, développée full-stack.',
                'description_ar' => 'منصّة عقارية في الإنتاج مع عروض وبحث ولوحات للوكلاء، مطوّرة full-stack.',
                'about_en' => 'BoonApp is a large real-estate product delivered end to end as a freelancer: property listings and media, search and filtering, and dashboards for agents. Built with Laravel and Vue on a MySQL database and shipped to production at boonapp.tn.',
                'about_fr' => "BoonApp est un grand produit immobilier livré de bout en bout en freelance : annonces et médias, recherche et filtres, tableaux de bord agents. Développé avec Laravel et Vue sur MySQL et mis en production sur boonapp.tn.",
                'about_ar' => 'BoonApp منتج عقاري كبير سُلّم بالكامل بصفة مستقل: عروض العقارات والوسائط، البحث والتصفية، ولوحات للوكلاء. مبني بـ Laravel وVue على قاعدة MySQL ومنشور في الإنتاج على boonapp.tn.',
                'client_en' => 'Freelance', 'client_fr' => 'Freelance', 'client_ar' => 'عمل حر',
                'live_demo_url' => 'https://boonapp.tn',
                'technologies' => ['Laravel', 'Vue.js', 'TypeScript', 'MySQL'],
                'features' => [
                    ['Property listings with media galleries', 'Annonces avec galeries média', 'عروض عقارية مع معارض وسائط'],
                    ['Search & filtering', 'Recherche et filtrage', 'بحث وتصفية'],
                    ['Agent dashboards', 'Tableaux de bord agents', 'لوحات تحكّم للوكلاء'],
                ],
                'roles' => [
                    ['fas fa-layer-group', 'Full-stack development', 'Développement full-stack', 'تطوير full-stack', 'Delivered the platform end to end — backend, API and frontend.', "Livraison de la plateforme de bout en bout — backend, API et frontend.", 'تسليم المنصّة بالكامل — الخلفية والـ API والواجهة.'],
                ],
            ],
            [
                'slug' => 'ecoboxfactory',
                'category' => 'web-apps',
                'project_type' => 'freelance',
                'is_featured' => true,
                'sort_order' => 2,
                'completed_date' => '2023-08-01',
                'title_en' => 'EcoBoxFactory', 'title_fr' => 'EcoBoxFactory', 'title_ar' => 'EcoBoxFactory',
                'subtitle_en' => 'Tiny-house product site (production)', 'subtitle_fr' => 'Site produit de tiny-houses (production)', 'subtitle_ar' => 'موقع منتجات المنازل الصغيرة (إنتاج)',
                'description_en' => 'A production product site for a tiny-house maker, built full-stack.',
                'description_fr' => 'Un site produit en production pour un fabricant de tiny-houses, développé full-stack.',
                'description_ar' => 'موقع منتجات في الإنتاج لصانع منازل صغيرة، مطوّر full-stack.',
                'about_en' => 'EcoBoxFactory presents a tiny-house product range with a catalogue, product pages and enquiry flows. Built full-stack with Laravel and Vue on PostgreSQL and shipped to production at ecoboxfactory.com.',
                'about_fr' => "EcoBoxFactory présente une gamme de tiny-houses avec catalogue, pages produit et demandes de contact. Développé full-stack avec Laravel et Vue sur PostgreSQL, en production sur ecoboxfactory.com.",
                'about_ar' => 'يعرض EcoBoxFactory تشكيلة منازل صغيرة مع كتالوج وصفحات منتجات ونماذج استفسار. مبني full-stack بـ Laravel وVue على PostgreSQL ومنشور على ecoboxfactory.com.',
                'client_en' => 'Freelance', 'client_fr' => 'Freelance', 'client_ar' => 'عمل حر',
                'live_demo_url' => 'https://ecoboxfactory.com',
                'technologies' => ['Laravel', 'Vue.js', 'TypeScript', 'PostgreSQL'],
                'features' => [
                    ['Product catalogue & detail pages', 'Catalogue et pages produit', 'كتالوج وصفحات منتجات'],
                    ['Enquiry / contact flows', 'Parcours de demande / contact', 'نماذج استفسار وتواصل'],
                ],
                'roles' => [
                    ['fas fa-layer-group', 'Full-stack development', 'Développement full-stack', 'تطوير full-stack', 'Built the catalogue, product pages and backend.', 'Création du catalogue, des pages produit et du backend.', 'بناء الكتالوج وصفحات المنتجات والخلفية.'],
                ],
            ],
            [
                'slug' => 'tenja7',
                'category' => 'education',
                'project_type' => 'freelance',
                'is_featured' => true,
                'sort_order' => 3,
                'completed_date' => '2023-04-01',
                'title_en' => 'Tenja7', 'title_fr' => 'Tenja7', 'title_ar' => 'Tenja7',
                'subtitle_en' => 'Education platform (production)', 'subtitle_fr' => 'Plateforme éducative (production)', 'subtitle_ar' => 'منصّة تعليمية (إنتاج)',
                'description_en' => 'A full-stack education platform with courses and student management.',
                'description_fr' => 'Une plateforme éducative full-stack avec cours et gestion des étudiants.',
                'description_ar' => 'منصّة تعليمية full-stack مع دورات وإدارة للطلاب.',
                'about_en' => 'Tenja7 is a production education platform delivering courses and content with student management, built full-stack with Laravel and Vue on MySQL and shipped at tenja7.tn.',
                'about_fr' => "Tenja7 est une plateforme éducative en production proposant cours et contenus avec gestion des étudiants, développée full-stack avec Laravel et Vue sur MySQL, en ligne sur tenja7.tn.",
                'about_ar' => 'Tenja7 منصّة تعليمية في الإنتاج تقدّم الدورات والمحتوى مع إدارة الطلاب، مبنية full-stack بـ Laravel وVue على MySQL ومنشورة على tenja7.tn.',
                'client_en' => 'Freelance', 'client_fr' => 'Freelance', 'client_ar' => 'عمل حر',
                'live_demo_url' => 'https://tenja7.tn',
                'technologies' => ['Laravel', 'Vue.js', 'TypeScript', 'MySQL'],
                'features' => [
                    ['Courses & content', 'Cours et contenus', 'الدورات والمحتوى'],
                    ['Student management', 'Gestion des étudiants', 'إدارة الطلاب'],
                ],
                'roles' => [
                    ['fas fa-layer-group', 'Full-stack development', 'Développement full-stack', 'تطوير full-stack', 'Built courses, content and student management end to end.', 'Développement des cours, contenus et gestion des étudiants de bout en bout.', 'بناء الدورات والمحتوى وإدارة الطلاب بالكامل.'],
                ],
            ],
            [
                'slug' => 'ai-toolbox',
                'category' => 'web-apps',
                'project_type' => 'academic',
                'is_featured' => true,
                'sort_order' => 4,
                'completed_date' => '2024-06-01',
                'title_en' => 'AI-Toolbox', 'title_fr' => 'AI-Toolbox', 'title_ar' => 'AI-Toolbox',
                'subtitle_en' => 'Final-year project — Laravel + Vue AI app', 'subtitle_fr' => 'Projet de fin d\'études — application IA Laravel + Vue', 'subtitle_ar' => 'مشروع التخرّج — تطبيق ذكاء اصطناعي Laravel + Vue',
                'description_en' => 'A full AI-Toolbox application built as the Software Engineering final-year project.',
                'description_fr' => "Une application AI-Toolbox complète, projet de fin d'études en génie logiciel.",
                'description_ar' => 'تطبيق AI-Toolbox كامل، مشروع تخرّج هندسة البرمجيات.',
                'about_en' => 'AI-Toolbox bundles several AI-powered tools behind a single Laravel + Vue application. Built as the Software Engineering license final-year project with full development ownership — from requirements to delivery.',
                'about_fr' => "AI-Toolbox regroupe plusieurs outils basés sur l'IA dans une seule application Laravel + Vue. Réalisé comme projet de fin d'études de la licence en génie logiciel, avec une pleine responsabilité du développement — des besoins à la livraison.",
                'about_ar' => 'يجمع AI-Toolbox عدّة أدوات مدعومة بالذكاء الاصطناعي في تطبيق واحد Laravel + Vue. أُنجز كمشروع تخرّج لإجازة هندسة البرمجيات بملكية تطوير كاملة — من المتطلبات إلى التسليم.',
                'client_en' => 'ISSAT Mateur — final-year project', 'client_fr' => 'ISSAT Mateur — projet de fin d\'études', 'client_ar' => 'ISSAT Mateur — مشروع تخرّج',
                'live_demo_url' => null,
                'technologies' => ['Laravel', 'Vue.js', 'PHP'],
                'features' => [
                    ['Multiple AI tools in one app', 'Plusieurs outils IA dans une app', 'عدّة أدوات ذكاء اصطناعي في تطبيق واحد'],
                    ['Full development ownership', 'Pleine responsabilité du développement', 'ملكية تطوير كاملة'],
                ],
                'roles' => [
                    ['fas fa-brain', 'End-to-end ownership', 'Responsabilité de bout en bout', 'مسؤولية شاملة', 'Owned requirements, architecture, development and delivery.', 'Prise en charge des besoins, de l\'architecture, du développement et de la livraison.', 'تولّي المتطلبات والهندسة والتطوير والتسليم.'],
                ],
            ],
            [
                'slug' => 'tolab',
                'category' => 'education',
                'project_type' => 'freelance',
                'is_featured' => false,
                'sort_order' => 5,
                'completed_date' => '2022-09-01',
                'title_en' => 'Tolab', 'title_fr' => 'Tolab', 'title_ar' => 'Tolab',
                'subtitle_en' => 'Full-stack education platform', 'subtitle_fr' => 'Plateforme éducative full-stack', 'subtitle_ar' => 'منصّة تعليمية full-stack',
                'description_en' => 'A full-stack education platform for courses and learners.',
                'description_fr' => 'Une plateforme éducative full-stack pour cours et apprenants.',
                'description_ar' => 'منصّة تعليمية full-stack للدورات والمتعلّمين.',
                'about_en' => 'Tolab is a full-stack education platform delivering courses to learners, built with Laravel and Vue on a MySQL database.',
                'about_fr' => 'Tolab est une plateforme éducative full-stack proposant des cours aux apprenants, développée avec Laravel et Vue sur MySQL.',
                'about_ar' => 'Tolab منصّة تعليمية full-stack تقدّم الدورات للمتعلّمين، مبنية بـ Laravel وVue على MySQL.',
                'client_en' => 'Freelance', 'client_fr' => 'Freelance', 'client_ar' => 'عمل حر',
                'live_demo_url' => null,
                'technologies' => ['Laravel', 'Vue.js', 'TypeScript', 'MySQL'],
                'features' => [
                    ['Courses & lessons', 'Cours et leçons', 'الدورات والدروس'],
                    ['Learner accounts', 'Comptes apprenants', 'حسابات المتعلّمين'],
                ],
                'roles' => [
                    ['fas fa-layer-group', 'Full-stack development', 'Développement full-stack', 'تطوير full-stack', 'Built the platform end to end.', 'Développement de la plateforme de bout en bout.', 'بناء المنصّة بالكامل.'],
                ],
            ],
            [
                'slug' => 'animated-landing-pages',
                'category' => 'landing-pages',
                'project_type' => 'freelance',
                'is_featured' => false,
                'sort_order' => 6,
                'completed_date' => '2023-01-01',
                'title_en' => 'Animated Landing Pages', 'title_fr' => 'Landing pages animées', 'title_ar' => 'صفحات هبوط متحرّكة',
                'subtitle_en' => 'Front-end / motion', 'subtitle_fr' => 'Front-end / motion', 'subtitle_ar' => 'واجهة أمامية / حركة',
                'description_en' => 'A set of animated marketing landing pages with motion and scroll effects.',
                'description_fr' => 'Un ensemble de landing pages marketing animées avec effets de mouvement et de défilement.',
                'description_ar' => 'مجموعة صفحات هبوط تسويقية متحرّكة مع تأثيرات حركة وتمرير.',
                'about_en' => 'Freelance front-end work: animated marketing landing pages with scroll-driven motion and interactive effects.',
                'about_fr' => 'Travail front-end en freelance : landing pages marketing animées avec mouvement au défilement et effets interactifs.',
                'about_ar' => 'عمل واجهة أمامية بصفة مستقل: صفحات هبوط تسويقية متحرّكة مع حركة مرتبطة بالتمرير وتأثيرات تفاعلية.',
                'client_en' => 'Freelance', 'client_fr' => 'Freelance', 'client_ar' => 'عمل حر',
                'live_demo_url' => null,
                'technologies' => ['JavaScript', 'Tailwind CSS'],
                'features' => [
                    ['Scroll-driven motion', 'Mouvement au défilement', 'حركة مرتبطة بالتمرير'],
                    ['Interactive animations', 'Animations interactives', 'رسوم متحرّكة تفاعلية'],
                ],
                'roles' => [
                    ['fas fa-wand-magic-sparkles', 'Front-end & motion', 'Front-end & motion', 'الواجهة والحركة', 'Designed and built animated, responsive landing pages.', 'Conception et développement de landing pages animées et responsives.', 'تصميم وبناء صفحات هبوط متحرّكة ومتجاوبة.'],
                ],
            ],
        ];

        foreach ($projects as $p) {
            DB::table('projects')->updateOrInsert(
                ['slug' => $p['slug']],
                [
                    'category_id' => $catId($p['category']),
                    'project_type' => $p['project_type'],
                    'thumbnail_url' => 'https://picsum.photos/seed/'.$p['slug'].'/800/600',
                    'hero_image_url' => 'https://picsum.photos/seed/'.$p['slug'].'-hero/1600/900',
                    'is_featured' => $p['is_featured'],
                    'is_active' => true,
                    'sort_order' => $p['sort_order'],
                    'title_en' => $p['title_en'], 'title_fr' => $p['title_fr'], 'title_ar' => $p['title_ar'],
                    'subtitle_en' => $p['subtitle_en'], 'subtitle_fr' => $p['subtitle_fr'], 'subtitle_ar' => $p['subtitle_ar'],
                    'description_en' => $p['description_en'], 'description_fr' => $p['description_fr'], 'description_ar' => $p['description_ar'],
                    'about_en' => $p['about_en'], 'about_fr' => $p['about_fr'], 'about_ar' => $p['about_ar'],
                    'client_en' => $p['client_en'], 'client_fr' => $p['client_fr'], 'client_ar' => $p['client_ar'],
                    'duration_en' => null, 'duration_fr' => null, 'duration_ar' => null,
                    'completed_date' => $p['completed_date'],
                    'live_demo_url' => $p['live_demo_url'],
                    'github_url' => null,
                    'updated_at' => $now, 'created_at' => $now,
                ]
            );

            $projectId = DB::table('projects')->where('slug', $p['slug'])->value('id');

            // Children — clear then insert (idempotent). One placeholder gallery image.
            DB::table('project_gallery')->where('project_id', $projectId)->delete();
            DB::table('project_gallery')->insert([
                'project_id' => $projectId,
                'image_url' => 'https://picsum.photos/seed/'.$p['slug'].'-g1/1200/800',
                'alt_en' => $p['title_en'], 'alt_fr' => $p['title_fr'], 'alt_ar' => $p['title_ar'],
                'sort_order' => 1, 'updated_at' => $now, 'created_at' => $now,
            ]);

            DB::table('project_features')->where('project_id', $projectId)->delete();
            foreach ($p['features'] as $i => [$en, $fr, $ar]) {
                DB::table('project_features')->insert([
                    'project_id' => $projectId, 'text_en' => $en, 'text_fr' => $fr, 'text_ar' => $ar,
                    'sort_order' => $i + 1, 'updated_at' => $now, 'created_at' => $now,
                ]);
            }

            DB::table('project_roles')->where('project_id', $projectId)->delete();
            foreach ($p['roles'] as $i => [$icon, $tEn, $tFr, $tAr, $bEn, $bFr, $bAr]) {
                DB::table('project_roles')->insert([
                    'project_id' => $projectId, 'icon_class' => $icon,
                    'title_en' => $tEn, 'title_fr' => $tFr, 'title_ar' => $tAr,
                    'body_en' => $bEn, 'body_fr' => $bFr, 'body_ar' => $bAr,
                    'sort_order' => $i + 1, 'updated_at' => $now, 'created_at' => $now,
                ]);
            }

            // Technology pivot.
            DB::table('project_technologies')->where('project_id', $projectId)->delete();
            foreach ($p['technologies'] as $i => $techName) {
                $techId = DB::table('technologies')->where('name', $techName)->value('id');
                if ($techId) {
                    DB::table('project_technologies')->insert([
                        'project_id' => $projectId, 'technology_id' => $techId, 'sort_order' => $i + 1,
                    ]);
                }
            }
        }

        // Projects section subheadings (defaults already cover the rest).
        DB::table('projects_section')->updateOrInsert(
            ['id' => 1],
            [
                'subheading_en' => 'Real products I have designed, built and shipped — freelance and academic.',
                'subheading_fr' => "De vrais produits que j'ai conçus, développés et livrés — freelance et académique.",
                'subheading_ar' => 'منتجات حقيقية صمّمتها وبنيتها وأطلقتها — عمل حر وأكاديمي.',
                'updated_at' => $now, 'created_at' => $now,
            ]
        );
    }
}

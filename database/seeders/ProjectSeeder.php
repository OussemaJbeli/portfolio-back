<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Projects: filter categories, project records, and their gallery, feature
 * checklist, "what I did" role cards and technology pivot.
 *
 * Idempotent: parents are upserted by slug; children are cleared per-project
 * and re-inserted so re-running never duplicates.
 */
class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        // ── Categories ────────────────────────────────────────────────────
        $categories = [
            ['web-apps', 'Web Applications', 'Applications Web', 'تطبيقات الويب', 1],
            ['apis', 'APIs & Backends', 'APIs & Backends', 'واجهات برمجية', 2],
            ['mobile', 'Mobile Apps', 'Applications Mobiles', 'تطبيقات الجوال', 3],
            ['open-source', 'Open Source', 'Open Source', 'مفتوح المصدر', 4],
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
                'slug' => 'portfolio-cms',
                'category' => 'web-apps',
                'is_featured' => true,
                'sort_order' => 1,
                'completed_date' => '2025-03-20',
                'title_en' => 'Portfolio CMS', 'title_fr' => 'CMS Portfolio', 'title_ar' => 'نظام إدارة المحفظة',
                'subtitle_en' => 'A trilingual, theme-aware content manager', 'subtitle_fr' => 'Un gestionnaire de contenu trilingue', 'subtitle_ar' => 'مدير محتوى ثلاثي اللغات',
                'description_en' => 'A headless CMS powering a developer portfolio, with a Vue admin and a Laravel API.',
                'description_fr' => "Un CMS headless qui alimente un portfolio de développeur, avec un admin Vue et une API Laravel.",
                'description_ar' => 'نظام إدارة محتوى يشغّل محفظة مطوّر، بواجهة إدارة Vue وواجهة Laravel.',
                'about_en' => 'Built a complete back-office to manage every section of a multilingual portfolio: hero, projects, blog and more. Content is editable in Arabic, French and English from a single switcher per field.',
                'about_fr' => "Création d'un back-office complet pour gérer chaque section d'un portfolio multilingue : hero, projets, blog et plus. Le contenu est éditable en arabe, français et anglais.",
                'about_ar' => 'بناء لوحة تحكم كاملة لإدارة كل قسم من المحفظة متعددة اللغات: الواجهة، المشاريع، المدونة وغيرها. المحتوى قابل للتحرير بالعربية والفرنسية والإنجليزية.',
                'client_en' => 'Personal', 'client_fr' => 'Personnel', 'client_ar' => 'شخصي',
                'duration_en' => '6 weeks', 'duration_fr' => '6 semaines', 'duration_ar' => '6 أسابيع',
                'thumbnail_url' => 'https://picsum.photos/seed/portfolio-cms/800/600',
                'hero_image_url' => 'https://picsum.photos/seed/portfolio-cms-hero/1600/900',
                'live_demo_url' => 'https://demo.example.com/portfolio-cms',
                'github_url' => 'https://github.com/oussema-jbeli/portfolio-cms',
                'technologies' => ['Vue.js', 'Laravel', 'TypeScript', 'Tailwind CSS', 'MySQL'],
                'gallery' => [
                    ['https://picsum.photos/seed/cms-g1/1200/800', 'Dashboard overview', "Vue d'ensemble du tableau de bord", 'نظرة عامة على لوحة التحكم'],
                    ['https://picsum.photos/seed/cms-g2/1200/800', 'Multilingual editor', 'Éditeur multilingue', 'محرّر متعدد اللغات'],
                ],
                'features' => [
                    ['One input + language switcher per field', 'Un champ + sélecteur de langue', 'حقل واحد مع مبدّل لغة'],
                    ['Image uploads per section', 'Téléversement d\'images par section', 'رفع الصور لكل قسم'],
                    ['Token-based auth with Sanctum', 'Authentification par token avec Sanctum', 'مصادقة بالرموز عبر Sanctum'],
                ],
                'roles' => [
                    ['fas fa-server', 'Backend & API', 'Backend & API', 'الخلفية والـ API', 'Designed the Laravel API, migrations and resource controllers.', "Conception de l'API Laravel, des migrations et des contrôleurs.", 'تصميم واجهة Laravel والهجرات والمتحكّمات.'],
                    ['fas fa-paint-brush', 'Frontend & UX', 'Frontend & UX', 'الواجهة وتجربة المستخدم', 'Built the Vue dashboard and the multilingual form system.', 'Création du tableau de bord Vue et du système de formulaires.', 'بناء لوحة Vue ونظام النماذج متعدد اللغات.'],
                ],
            ],
            [
                'slug' => 'taskflow-saas',
                'category' => 'web-apps',
                'is_featured' => true,
                'sort_order' => 2,
                'completed_date' => '2024-12-10',
                'title_en' => 'TaskFlow', 'title_fr' => 'TaskFlow', 'title_ar' => 'TaskFlow',
                'subtitle_en' => 'Realtime team task management', 'subtitle_fr' => "Gestion de tâches d'équipe en temps réel", 'subtitle_ar' => 'إدارة مهام الفريق في الوقت الحقيقي',
                'description_en' => 'A SaaS for teams to plan, assign and track work with realtime boards.',
                'description_fr' => 'Un SaaS pour planifier, assigner et suivre le travail avec des tableaux en temps réel.',
                'description_ar' => 'منصة SaaS للفرق لتخطيط المهام وإسنادها وتتبّعها بلوحات فورية.',
                'about_en' => 'TaskFlow gives teams kanban boards, assignments and notifications backed by websockets, with role-based access and an audit trail.',
                'about_fr' => 'TaskFlow offre des tableaux kanban, des assignations et des notifications via websockets, avec des accès par rôle et un journal d\'audit.',
                'about_ar' => 'يوفّر TaskFlow لوحات كانبان وإسناد المهام وإشعارات عبر websockets، مع صلاحيات حسب الدور وسجلّ تدقيق.',
                'client_en' => 'Acme Inc.', 'client_fr' => 'Acme Inc.', 'client_ar' => 'Acme Inc.',
                'duration_en' => '4 months', 'duration_fr' => '4 mois', 'duration_ar' => '4 أشهر',
                'thumbnail_url' => 'https://picsum.photos/seed/taskflow/800/600',
                'hero_image_url' => 'https://picsum.photos/seed/taskflow-hero/1600/900',
                'live_demo_url' => 'https://demo.example.com/taskflow',
                'github_url' => null,
                'technologies' => ['Vue.js', 'Laravel', 'Redis', 'PostgreSQL', 'Docker'],
                'gallery' => [
                    ['https://picsum.photos/seed/tf-g1/1200/800', 'Kanban board', 'Tableau kanban', 'لوحة كانبان'],
                    ['https://picsum.photos/seed/tf-g2/1200/800', 'Team dashboard', "Tableau de bord d'équipe", 'لوحة الفريق'],
                ],
                'features' => [
                    ['Realtime kanban with websockets', 'Kanban en temps réel via websockets', 'كانبان فوري عبر websockets'],
                    ['Role-based permissions', 'Permissions basées sur les rôles', 'صلاحيات حسب الدور'],
                    ['Email & in-app notifications', 'Notifications email et in-app', 'إشعارات بالبريد وداخل التطبيق'],
                ],
                'roles' => [
                    ['fas fa-bolt', 'Realtime layer', 'Couche temps réel', 'طبقة الزمن الحقيقي', 'Implemented websocket broadcasting and presence.', 'Mise en place de la diffusion websocket et de la présence.', 'تنفيذ البثّ الفوري وحضور المستخدمين.'],
                    ['fas fa-lock', 'Auth & roles', 'Auth & rôles', 'المصادقة والأدوار', 'Built RBAC and the audit trail.', 'Création du RBAC et du journal d\'audit.', 'بناء نظام الصلاحيات وسجلّ التدقيق.'],
                ],
            ],
            [
                'slug' => 'shopnest-api',
                'category' => 'apis',
                'is_featured' => false,
                'sort_order' => 3,
                'completed_date' => '2024-08-05',
                'title_en' => 'ShopNest API', 'title_fr' => 'API ShopNest', 'title_ar' => 'واجهة ShopNest',
                'subtitle_en' => 'E-commerce REST API', 'subtitle_fr' => 'API REST e-commerce', 'subtitle_ar' => 'واجهة REST للتجارة الإلكترونية',
                'description_en' => 'A scalable e-commerce API with carts, orders, payments and inventory.',
                'description_fr' => 'Une API e-commerce évolutive avec paniers, commandes, paiements et stock.',
                'description_ar' => 'واجهة برمجية قابلة للتوسّع للتجارة الإلكترونية مع السلة والطلبات والمدفوعات والمخزون.',
                'about_en' => 'A documented REST API powering web and mobile storefronts, with Stripe payments, webhooks and queued jobs for fulfilment.',
                'about_fr' => 'Une API REST documentée pour boutiques web et mobiles, avec paiements Stripe, webhooks et jobs en file pour la logistique.',
                'about_ar' => 'واجهة REST موثّقة تشغّل متاجر الويب والجوال، مع مدفوعات Stripe وwebhooks ومهام مجدولة للتنفيذ.',
                'client_en' => 'Retail startup', 'client_fr' => 'Startup retail', 'client_ar' => 'شركة ناشئة للتجزئة',
                'duration_en' => '3 months', 'duration_fr' => '3 mois', 'duration_ar' => '3 أشهر',
                'thumbnail_url' => 'https://picsum.photos/seed/shopnest/800/600',
                'hero_image_url' => 'https://picsum.photos/seed/shopnest-hero/1600/900',
                'live_demo_url' => null,
                'github_url' => 'https://github.com/oussema-jbeli/shopnest-api',
                'technologies' => ['Laravel', 'PHP', 'MySQL', 'Redis', 'Docker'],
                'gallery' => [
                    ['https://picsum.photos/seed/sn-g1/1200/800', 'API documentation', 'Documentation API', 'توثيق الواجهة'],
                ],
                'features' => [
                    ['OpenAPI documentation', 'Documentation OpenAPI', 'توثيق OpenAPI'],
                    ['Stripe payments & webhooks', 'Paiements Stripe & webhooks', 'مدفوعات Stripe وwebhooks'],
                    ['Queued order fulfilment', 'Traitement des commandes en file', 'تنفيذ الطلبات عبر الطوابير'],
                ],
                'roles' => [
                    ['fas fa-database', 'Architecture', 'Architecture', 'الهندسة', 'Modelled the domain and database schema.', 'Modélisation du domaine et du schéma.', 'نمذجة المجال ومخطّط قاعدة البيانات.'],
                ],
            ],
            [
                'slug' => 'fittrack-mobile',
                'category' => 'mobile',
                'is_featured' => false,
                'sort_order' => 4,
                'completed_date' => '2024-05-18',
                'title_en' => 'FitTrack', 'title_fr' => 'FitTrack', 'title_ar' => 'FitTrack',
                'subtitle_en' => 'Workout tracking companion', 'subtitle_fr' => "Compagnon de suivi d'entraînement", 'subtitle_ar' => 'رفيق تتبّع التمارين',
                'description_en' => 'A mobile app to log workouts, track progress and set goals.',
                'description_fr' => "Une application mobile pour enregistrer les entraînements et suivre les progrès.",
                'description_ar' => 'تطبيق جوال لتسجيل التمارين وتتبّع التقدّم وتحديد الأهداف.',
                'about_en' => 'Cross-platform app with offline-first sync, charts and reminders, backed by a lightweight API.',
                'about_fr' => 'Application multiplateforme avec synchronisation offline-first, graphiques et rappels, adossée à une API légère.',
                'about_ar' => 'تطبيق متعدّد المنصّات مع مزامنة تعمل دون اتصال أولًا، ورسوم بيانية وتذكيرات، مدعوم بواجهة خفيفة.',
                'client_en' => 'Personal', 'client_fr' => 'Personnel', 'client_ar' => 'شخصي',
                'duration_en' => '2 months', 'duration_fr' => '2 mois', 'duration_ar' => 'شهران',
                'thumbnail_url' => 'https://picsum.photos/seed/fittrack/800/600',
                'hero_image_url' => 'https://picsum.photos/seed/fittrack-hero/1600/900',
                'live_demo_url' => null,
                'github_url' => 'https://github.com/oussema-jbeli/fittrack',
                'technologies' => ['React', 'TypeScript', 'Node.js'],
                'gallery' => [
                    ['https://picsum.photos/seed/ft-g1/1200/800', 'Progress charts', 'Graphiques de progrès', 'رسوم التقدّم'],
                ],
                'features' => [
                    ['Offline-first sync', 'Synchronisation offline-first', 'مزامنة دون اتصال أولًا'],
                    ['Progress charts', 'Graphiques de progrès', 'رسوم بيانية للتقدّم'],
                ],
                'roles' => [
                    ['fas fa-mobile-screen', 'Mobile app', 'Application mobile', 'تطبيق الجوال', 'Built the app and offline sync engine.', 'Création de l\'app et du moteur de synchronisation.', 'بناء التطبيق ومحرّك المزامنة دون اتصال.'],
                ],
            ],
        ];

        foreach ($projects as $p) {
            DB::table('projects')->updateOrInsert(
                ['slug' => $p['slug']],
                [
                    'category_id' => $catId($p['category']),
                    'thumbnail_url' => $p['thumbnail_url'],
                    'hero_image_url' => $p['hero_image_url'],
                    'is_featured' => $p['is_featured'],
                    'is_active' => true,
                    'sort_order' => $p['sort_order'],
                    'title_en' => $p['title_en'], 'title_fr' => $p['title_fr'], 'title_ar' => $p['title_ar'],
                    'subtitle_en' => $p['subtitle_en'], 'subtitle_fr' => $p['subtitle_fr'], 'subtitle_ar' => $p['subtitle_ar'],
                    'description_en' => $p['description_en'], 'description_fr' => $p['description_fr'], 'description_ar' => $p['description_ar'],
                    'about_en' => $p['about_en'], 'about_fr' => $p['about_fr'], 'about_ar' => $p['about_ar'],
                    'client_en' => $p['client_en'], 'client_fr' => $p['client_fr'], 'client_ar' => $p['client_ar'],
                    'duration_en' => $p['duration_en'], 'duration_fr' => $p['duration_fr'], 'duration_ar' => $p['duration_ar'],
                    'completed_date' => $p['completed_date'],
                    'live_demo_url' => $p['live_demo_url'],
                    'github_url' => $p['github_url'],
                    'updated_at' => $now, 'created_at' => $now,
                ]
            );

            $projectId = DB::table('projects')->where('slug', $p['slug'])->value('id');

            // Children — clear then insert (idempotent).
            DB::table('project_gallery')->where('project_id', $projectId)->delete();
            foreach ($p['gallery'] as $i => [$url, $altEn, $altFr, $altAr]) {
                DB::table('project_gallery')->insert([
                    'project_id' => $projectId, 'image_url' => $url,
                    'alt_en' => $altEn, 'alt_fr' => $altFr, 'alt_ar' => $altAr,
                    'sort_order' => $i + 1, 'updated_at' => $now, 'created_at' => $now,
                ]);
            }

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
                'subheading_en' => 'A selection of products I have designed and built.',
                'subheading_fr' => "Une sélection de produits que j'ai conçus et développés.",
                'subheading_ar' => 'مجموعة مختارة من المنتجات التي صمّمتها وبنيتها.',
                'updated_at' => $now, 'created_at' => $now,
            ]
        );
    }
}

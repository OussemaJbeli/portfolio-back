<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Home-page content: hero, about + bullets, skill categories and technologies.
 */
class HomeSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        // ── Hero ──────────────────────────────────────────────────────────
        DB::table('hero')->updateOrInsert(
            ['id' => 1],
            [
                'badge_en' => '> FULL-STACK DEVELOPER',
                'badge_fr' => '> DÉVELOPPEUR FULL-STACK',
                'badge_ar' => '> مطوّر full-stack',
                'greeting_en' => "Hello, I'm",
                'greeting_fr' => 'Bonjour, je suis',
                'greeting_ar' => 'مرحبًا، أنا',
                'full_name' => 'Oussema Jbeli',
                'typewriter_en' => json_encode(['I build modern web apps', 'I design clean interfaces', 'I ship reliable APIs']),
                'typewriter_fr' => json_encode(['Je crée des applications web modernes', 'Je conçois des interfaces épurées', 'Je livre des APIs fiables']),
                'typewriter_ar' => json_encode(['أبني تطبيقات ويب حديثة', 'أصمّم واجهات أنيقة', 'أطوّر واجهات برمجية موثوقة']),
                'tagline_en' => 'I craft fast, accessible and maintainable products from database to pixel.',
                'tagline_fr' => 'Je conçois des produits rapides, accessibles et maintenables, de la base de données au pixel.',
                'tagline_ar' => 'أصنع منتجات سريعة وسهلة الوصول وقابلة للصيانة، من قاعدة البيانات إلى أدق التفاصيل.',
                'photo_url' => 'https://i.pravatar.cc/600?img=12',
                'cta_primary_label_en' => 'Download CV',
                'cta_primary_label_fr' => 'Télécharger CV',
                'cta_primary_label_ar' => 'تحميل السيرة الذاتية',
                'cta_primary_url' => 'https://example.com/oussema-jbeli-cv.pdf',
                'cta_secondary_label_en' => 'View My Works',
                'cta_secondary_label_fr' => 'Voir mes travaux',
                'cta_secondary_label_ar' => 'عرض أعمالي',
                'cta_secondary_url' => '#projects',
                'code_badge' => '</>',
                'updated_at' => $now,
                'created_at' => $now,
            ]
        );

        // ── Stats ───────────────────────────────────────────────────────
        $stats = [
            ['50+', 'fas fa-rocket', 'Projects Completed', 'Projets réalisés', 'مشاريع منجزة', 1],
            ['30+', 'fas fa-face-smile', 'Happy Clients', 'Clients satisfaits', 'عملاء سعداء', 2],
            ['3+', 'fas fa-award', 'Years Experience', 'Ans d\'expérience', 'سنوات خبرة', 3],
            ['100%', 'fas fa-code', 'Commitment', 'Engagement', 'الالتزام', 4],
        ];
        foreach ($stats as [$value, $icon, $en, $fr, $ar, $order]) {
            DB::table('stats')->updateOrInsert(
                ['label_en' => $en],
                ['value' => $value, 'icon_class' => $icon, 'label_fr' => $fr, 'label_ar' => $ar, 'sort_order' => $order, 'is_active' => true, 'updated_at' => $now, 'created_at' => $now]
            );
        }

        // ── About ─────────────────────────────────────────────────────────
        DB::table('about')->updateOrInsert(
            ['id' => 1],
            [
                'bio_en' => "I'm a full-stack developer with 3+ years of experience building web applications end to end. I specialise in Vue, Laravel and TypeScript, and I care deeply about clean architecture, performance and great user experience.",
                'bio_fr' => "Je suis développeur full-stack avec plus de 3 ans d'expérience dans la création d'applications web de bout en bout. Je me spécialise en Vue, Laravel et TypeScript, avec une attention particulière à l'architecture, la performance et l'expérience utilisateur.",
                'bio_ar' => 'أنا مطوّر full-stack بخبرة تزيد عن 3 سنوات في بناء تطبيقات الويب من البداية إلى النهاية. أتخصّص في Vue وLaravel وTypeScript، وأهتمّ كثيرًا بنظافة البنية والأداء وتجربة المستخدم.',
                'photo_url' => 'https://i.pravatar.cc/600?img=12',
                'display_name' => 'Oussema Jbeli',
                'email' => 'hello@oussemajbeli.dev',
                'location_en' => 'Tunis, Tunisia',
                'location_fr' => 'Tunis, Tunisie',
                'location_ar' => 'تونس، تونس',
                'cta_url' => '#contact',
                'updated_at' => $now,
                'created_at' => $now,
            ]
        );

        // ── About bullets ─────────────────────────────────────────────────
        $bullets = [
            ['fas fa-briefcase', '3+ years of professional experience', "Plus de 3 ans d'expérience professionnelle", 'أكثر من 3 سنوات من الخبرة المهنية', 1],
            ['fas fa-rocket', '50+ projects delivered', '50+ projets livrés', 'أكثر من 50 مشروعًا تم تسليمه', 2],
            ['fas fa-graduation-cap', 'BSc in Computer Science', 'Licence en informatique', 'إجازة في علوم الحاسوب', 3],
            ['fas fa-language', 'Fluent in Arabic, French & English', 'Arabe, français et anglais courants', 'إتقان العربية والفرنسية والإنجليزية', 4],
        ];
        foreach ($bullets as [$icon, $en, $fr, $ar, $order]) {
            DB::table('about_bullets')->updateOrInsert(
                ['text_en' => $en],
                ['icon_class' => $icon, 'text_fr' => $fr, 'text_ar' => $ar, 'sort_order' => $order, 'is_active' => true, 'updated_at' => $now, 'created_at' => $now]
            );
        }

        // ── Skill categories ──────────────────────────────────────────────
        $skills = [
            ['Frontend Development', 'Développement Frontend', 'تطوير الواجهات الأمامية', 92, 1],
            ['Backend Development', 'Développement Backend', 'تطوير الواجهات الخلفية', 88, 2],
            ['Databases', 'Bases de données', 'قواعد البيانات', 82, 3],
            ['DevOps & Cloud', 'DevOps & Cloud', 'DevOps والسحابة', 75, 4],
            ['UI / UX Design', 'Design UI / UX', 'تصميم UI / UX', 70, 5],
        ];
        foreach ($skills as [$en, $fr, $ar, $pct, $order]) {
            DB::table('skill_categories')->updateOrInsert(
                ['name_en' => $en],
                ['name_fr' => $fr, 'name_ar' => $ar, 'percentage' => $pct, 'sort_order' => $order, 'is_active' => true, 'updated_at' => $now, 'created_at' => $now]
            );
        }

        // ── Technologies ──────────────────────────────────────────────────
        $techs = [
            ['Vue.js', 'devicon-vuejs-plain', '#42B883'],
            ['Laravel', 'devicon-laravel-plain', '#FF2D20'],
            ['TypeScript', 'devicon-typescript-plain', '#3178C6'],
            ['JavaScript', 'devicon-javascript-plain', '#F7DF1E'],
            ['PHP', 'devicon-php-plain', '#777BB4'],
            ['Node.js', 'devicon-nodejs-plain', '#339933'],
            ['React', 'devicon-react-original', '#61DAFB'],
            ['Tailwind CSS', 'devicon-tailwindcss-plain', '#06B6D4'],
            ['MySQL', 'devicon-mysql-plain', '#4479A1'],
            ['PostgreSQL', 'devicon-postgresql-plain', '#4169E1'],
            ['Docker', 'devicon-docker-plain', '#2496ED'],
            ['Redis', 'devicon-redis-plain', '#DC382D'],
            ['Git', 'devicon-git-plain', '#F05032'],
            ['Figma', 'devicon-figma-plain', '#F24E1E'],
        ];
        foreach ($techs as [$name, $icon, $color]) {
            DB::table('technologies')->updateOrInsert(
                ['name' => $name],
                ['icon_class' => $icon, 'color' => $color, 'updated_at' => $now, 'created_at' => $now]
            );
        }
    }
}

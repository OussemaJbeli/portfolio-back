<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Home-page content: hero, about + bullets, the skills section heading,
 * skill categories and technologies.
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
                'badge_en' => '> DEVOPS · FULL-STACK · AI ENGINEER',
                'badge_fr' => '> INGÉNIEUR DEVOPS · FULL-STACK · IA',
                'badge_ar' => '> مهندس DevOps · Full-Stack · ذكاء اصطناعي',
                'greeting_en' => "Hello, I'm",
                'greeting_fr' => 'Bonjour, je suis',
                'greeting_ar' => 'مرحبًا، أنا',
                'full_name' => 'Oussema Jbeli',
                'typewriter_en' => json_encode(['DevOps & Cloud (AWS)', 'Full-Stack — Laravel · Vue · TypeScript', 'AI & Data Science', 'CI/CD · Docker · Microservices']),
                'typewriter_fr' => json_encode(['DevOps & Cloud (AWS)', 'Full-Stack — Laravel · Vue · TypeScript', 'IA & Data Science', 'CI/CD · Docker · Microservices']),
                'typewriter_ar' => json_encode(['DevOps وسحابة (AWS)', 'Full-Stack — Laravel · Vue · TypeScript', 'ذكاء اصطناعي وعلوم بيانات', 'CI/CD · Docker · خدمات مصغّرة']),
                'tagline_en' => 'Software & AI/Data Science engineer working across DevOps, cloud (AWS) and full-stack — building and shipping real products.',
                'tagline_fr' => "Ingénieur logiciel & IA/Data Science, actif en DevOps, cloud (AWS) et full-stack — je conçois et livre de vrais produits.",
                'tagline_ar' => 'مهندس برمجيات وذكاء اصطناعي/علوم بيانات في DevOps والسحابة (AWS) والتطوير full-stack — أبني وأطلق منتجات حقيقية.',
                'photo_url' => '/assets/hero/home.png',
                'cta_primary_label_en' => 'Download CV',
                'cta_primary_label_fr' => 'Télécharger CV',
                'cta_primary_label_ar' => 'تحميل السيرة الذاتية',
                'cta_primary_url' => 'https://example.com/oussema-jbeli-cv.pdf',
                'cta_secondary_label_en' => 'View My Works',
                'cta_secondary_label_fr' => 'Voir mes travaux',
                'cta_secondary_label_ar' => 'عرض أعمالي',
                'cta_secondary_url' => '/projects',
                'code_badge' => '</>',
                'updated_at' => $now,
                'created_at' => $now,
            ]
        );

        // ── Stats ───────────────────────────────────────────────────────
        $stats = [
            ['5+', 'fas fa-rocket', 'Projects Delivered', 'Projets livrés', 'مشاريع مُسلّمة', 1],
            ['3+', 'fas fa-briefcase', 'Years Experience', "Ans d'expérience", 'سنوات خبرة', 2],
            ['6', 'fas fa-graduation-cap', 'Eng. Degrees', "Diplômes d'ing.", 'شهادات هندسية', 3],
            ['15+', 'fas fa-code', 'Technologies', 'Technologies', 'تقنيات', 4],
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
                'photo_url' => '/assets/about/about.png',
                'display_name' => 'Oussema Jbeli',
                'email' => 'jbelioussema33@gmail.com',
                'location_en' => 'Amdoun, Béja, Tunisia',
                'location_fr' => 'Amdoun, Béja, Tunisie',
                'location_ar' => 'عمدون، باجة، تونس',
                'summary_en' => 'Software and AI/Data Science engineer with hands-on experience across the full delivery pipeline — from full-stack development to CI/CD, cloud infrastructure and microservices. I hold a Software Engineering license and am completing an AI & Data Science engineering degree (2027). Alongside my studies I have shipped production freelance projects and now work as a DevOps engineer at Emertek-AL, building pipelines and deploying on AWS.',
                'summary_fr' => "Ingénieur logiciel et IA/Data Science avec une expérience concrète sur toute la chaîne de livraison — du développement full-stack au CI/CD, à l'infrastructure cloud et aux microservices. Titulaire d'une licence en génie logiciel et en cours d'un diplôme d'ingénieur IA & Data Science (2027). En parallèle de mes études, j'ai livré des projets freelance en production et je travaille désormais comme ingénieur DevOps chez Emertek-AL.",
                'summary_ar' => 'مهندس برمجيات وذكاء اصطناعي/علوم بيانات بخبرة عملية عبر كامل سلسلة التسليم — من التطوير full-stack إلى CI/CD والبنية السحابية والخدمات المصغّرة. أحمل إجازة في هندسة البرمجيات وأُكمل حاليًا شهادة هندسة الذكاء الاصطناعي وعلوم البيانات (2027). إلى جانب دراستي، سلّمت مشاريع freelance في الإنتاج وأعمل الآن مهندس DevOps في Emertek-AL.',
                'open_to_en' => 'DevOps · Full-Stack · Cloud · MLOps roles · freelance · internships',
                'open_to_fr' => 'Postes DevOps · Full-Stack · Cloud · MLOps · freelance · stages',
                'open_to_ar' => 'وظائف DevOps · Full-Stack · Cloud · MLOps · عمل حر · تدريبات',
                'cta_url' => '#contact',
                'updated_at' => $now,
                'created_at' => $now,
            ]
        );

        // ── About bullets ─────────────────────────────────────────────────
        $bullets = [
            ['fas fa-server', 'DevOps / Full-Stack Engineer @ Emertek-AL', 'Ingénieur DevOps / Full-Stack @ Emertek-AL', 'مهندس DevOps / Full-Stack في Emertek-AL', 1],
            ['fas fa-graduation-cap', 'Software Engineering license — ISSAT Mateur', 'Licence en génie logiciel — ISSAT Mateur', 'إجازة في هندسة البرمجيات — ISSAT Mateur', 2],
            ['fas fa-brain', 'AI & Data Science engineering — Iteams (2027)', 'Ingénierie IA & Data Science — Iteams (2027)', 'هندسة الذكاء الاصطناعي وعلوم البيانات — Iteams (2027)', 3],
            ['fas fa-rocket', '5+ freelance platforms delivered since 2023', '5+ plateformes freelance livrées depuis 2023', 'أكثر من 5 منصّات freelance مُسلّمة منذ 2023', 4],
        ];
        foreach ($bullets as [$icon, $en, $fr, $ar, $order]) {
            DB::table('about_bullets')->updateOrInsert(
                ['text_en' => $en],
                ['icon_class' => $icon, 'text_fr' => $fr, 'text_ar' => $ar, 'sort_order' => $order, 'is_active' => true, 'updated_at' => $now, 'created_at' => $now]
            );
        }

        // ── Skills section heading (singleton) ────────────────────────────
        DB::table('skills_section')->updateOrInsert(
            ['id' => 1],
            [
                'section_badge_en' => '> SKILLS',
                'section_badge_fr' => '> COMPÉTENCES',
                'section_badge_ar' => '> المهارات',
                'heading_en' => 'My Skills',
                'heading_fr' => 'Mes compétences',
                'heading_ar' => 'مهاراتي',
                'updated_at' => $now,
                'created_at' => $now,
            ]
        );

        // ── Skill categories ──────────────────────────────────────────────
        $skills = [
            ['Backend Development', 'Développement Backend', 'تطوير الواجهات الخلفية', 85, 1],
            ['Frontend Development', 'Développement Frontend', 'تطوير الواجهات الأمامية', 85, 2],
            ['DevOps & Cloud', 'DevOps & Cloud', 'DevOps والسحابة', 80, 3],
            ['Databases', 'Bases de données', 'قواعد البيانات', 80, 4],
            ['AI / Data Science', 'IA / Data Science', 'الذكاء الاصطناعي وعلوم البيانات', 65, 5],
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

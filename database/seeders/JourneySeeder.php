<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * The Journey: a plain-language career timeline, deliberately kept SHORT.
 *
 * Curated down to EIGHT steps across seven paths. The previous version had 28
 * steps, which made the section long and repetitive — every one looked and felt
 * like every other, so none of them landed. Each step here is one a recruiter
 * would actually care about, which lets the frontend give every single one a
 * proper arrival instead of rushing through a list.
 *
 * What was folded away (still visible elsewhere on the site):
 *   • Course-by-course study steps → the Skills section already covers them.
 *   • Individual freelance projects → the Projects section shows all of them;
 *     the journey states the outcome ("five production platforms") and links the
 *     flagship one.
 *   • Task-level work items (built the pipelines, added monitoring…) → these are
 *     responsibilities of the current role, not separate life events.
 *
 * No git vocabulary: no branches, no merges, no commit prefixes, no version
 * tags. `kind` is used only as a shape hint for the frontend:
 *   • 'tag'    → a formal qualification earned
 *   • 'head'   → the current position
 *   • 'commit' → every other step
 * `commit_hash` is still generated because the column is NOT NULL, but nothing
 * displays it.
 *
 * Idempotent: paths are upserted by slug, paths that no longer exist are deleted
 * (cascading their milestones + technology pivots), and each path's milestones
 * are cleared and re-inserted.
 */
class JourneySeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        // ── Section heading ────────────────────────────────────────────────
        DB::table('journey_section')->updateOrInsert(
            ['id' => 1],
            [
                'section_badge_en' => '> MY JOURNEY',
                'section_badge_fr' => '> MON PARCOURS',
                'section_badge_ar' => '> مسيرتي',
                'heading_en' => 'My Journey',
                'heading_fr' => 'Mon Parcours',
                'heading_ar' => 'مسيرتي',
                'subheading_en' => 'From a technical baccalaureate to DevOps engineering — eight steps that turned studying software into shipping it.',
                'subheading_fr' => "Du baccalauréat technique à l'ingénierie DevOps — huit étapes qui ont transformé l'étude du logiciel en livraison de logiciel.",
                'subheading_ar' => 'من الباكالوريا التقنية إلى هندسة DevOps — ثماني خطوات حوّلت دراسة البرمجيات إلى إطلاقها.',
                'next_label_en' => 'Next: graduating as an AI & Data Science engineer in 2027',
                'next_label_fr' => "Prochaine étape : diplôme d'ingénieur IA & Data Science en 2027",
                'next_label_ar' => 'الخطوة القادمة: التخرّج مهندس ذكاء اصطناعي وعلوم بيانات في 2027',
                'updated_at' => $now,
                'created_at' => $now,
            ]
        );

        // ── The seven paths ────────────────────────────────────────────────
        // Colours are explicit and deliberately all different, because with only
        // eight steps each one gets its own destination on the frontend and two
        // identical colours would waste that. The palette warms as the career
        // progresses: blue (school) → steel (first jobs) → orange (freelance) →
        // cyan (own product) → violet (AI) → green (production).
        $tracks = [
            [
                'slug' => 'education-baccalaureate',
                'branch_name' => 'Baccalaureate',
                'type' => 'education',
                'employment_type' => null,
                'color' => '#4f9dff',
                'icon_class' => 'fas fa-school',
                'label_en' => 'Technical Baccalaureate', 'label_fr' => 'Baccalauréat Technique', 'label_ar' => 'الباكالوريا التقنية',
                'org_en' => 'Lycée 2 Mars 1934', 'org_fr' => 'Lycée 2 Mars 1934', 'org_ar' => 'معهد 2 مارس 1934',
                'location_en' => 'Béja, Tunisia', 'location_fr' => 'Béja, Tunisie', 'location_ar' => 'باجة، تونس',
                'started_at' => '2020-09-01', 'ended_at' => '2021-06-30',
                'lane_index' => 0, 'sort_order' => 1,
            ],
            [
                'slug' => 'education-license',
                'branch_name' => 'Software Engineering',
                'type' => 'education',
                'employment_type' => null,
                'color' => '#6d8bff',
                'icon_class' => 'fas fa-graduation-cap',
                'label_en' => 'Software Engineering License', 'label_fr' => 'Licence en génie logiciel', 'label_ar' => 'إجازة في هندسة البرمجيات',
                'org_en' => 'ISSAT Mateur', 'org_fr' => 'ISSAT Mateur', 'org_ar' => 'المعهد العالي للعلوم التطبيقية والتكنولوجيا بماطر',
                'location_en' => 'Mateur, Tunisia', 'location_fr' => 'Mateur, Tunisie', 'location_ar' => 'ماطر، تونس',
                'started_at' => '2021-09-01', 'ended_at' => '2024-06-30',
                'lane_index' => 1, 'sort_order' => 2,
            ],
            [
                'slug' => 'work-internships',
                'branch_name' => 'Internships',
                'type' => 'work',
                'employment_type' => 'internship',
                // Steel, not green — the current role owns green.
                'color' => '#8fb7cc',
                'icon_class' => 'fas fa-user-graduate',
                'label_en' => 'Internships', 'label_fr' => 'Stages', 'label_ar' => 'التدريبات',
                'org_en' => 'Emertek · Leemcode', 'org_fr' => 'Emertek · Leemcode', 'org_ar' => 'Emertek · Leemcode',
                'location_en' => 'Tunisia', 'location_fr' => 'Tunisie', 'location_ar' => 'تونس',
                'started_at' => '2022-06-01', 'ended_at' => '2023-08-31',
                'lane_index' => 2, 'sort_order' => 3,
            ],
            [
                'slug' => 'freelance',
                'branch_name' => 'Freelance',
                'type' => 'freelance',
                'employment_type' => 'freelance',
                'color' => '#ff8c1a',
                'icon_class' => 'fas fa-rocket',
                'label_en' => 'Freelance Projects', 'label_fr' => 'Projets en freelance', 'label_ar' => 'مشاريع العمل الحر',
                'org_en' => 'Independent', 'org_fr' => 'Indépendant', 'org_ar' => 'مستقل',
                'location_en' => 'Tunisia · Remote', 'location_fr' => 'Tunisie · À distance', 'location_ar' => 'تونس · عن بُعد',
                'started_at' => '2023-11-01', 'ended_at' => null,
                'lane_index' => 3, 'sort_order' => 4,
            ],
            [
                // Its own path so the strongest engineering piece gets its own
                // destination rather than hiding inside "Internships".
                'slug' => 'capstone',
                'branch_name' => 'Capstone',
                'type' => 'self',
                'employment_type' => null,
                'color' => '#22d3ee',
                'icon_class' => 'fas fa-wand-magic-sparkles',
                'label_en' => 'Final-Year Project', 'label_fr' => "Projet de fin d'études", 'label_ar' => 'مشروع التخرّج',
                'org_en' => 'ISSAT Mateur · Leemcode', 'org_fr' => 'ISSAT Mateur · Leemcode', 'org_ar' => 'ISSAT ماطر · Leemcode',
                'location_en' => 'Tunisia', 'location_fr' => 'Tunisie', 'location_ar' => 'تونس',
                'started_at' => '2024-01-15', 'ended_at' => '2024-06-30',
                'lane_index' => 4, 'sort_order' => 5,
            ],
            [
                'slug' => 'education-engineering',
                'branch_name' => 'AI & Data Science',
                'type' => 'education',
                'employment_type' => null,
                // Violet — this is the AI chapter, not more of the same schooling.
                'color' => '#b57bff',
                'icon_class' => 'fas fa-brain',
                'label_en' => 'AI & Data Science Engineering', 'label_fr' => 'Ingénierie IA & Data Science', 'label_ar' => 'هندسة الذكاء الاصطناعي وعلوم البيانات',
                'org_en' => 'Iteams', 'org_fr' => 'Iteams', 'org_ar' => 'Iteams',
                'location_en' => 'Tunisia', 'location_fr' => 'Tunisie', 'location_ar' => 'تونس',
                'started_at' => '2024-09-01', 'ended_at' => null,
                'lane_index' => 5, 'sort_order' => 6,
            ],
            [
                'slug' => 'work-emertek-al',
                'branch_name' => 'Emertek-AL',
                'type' => 'work',
                'employment_type' => 'full_time',
                'color' => '#2ee6a6',
                'icon_class' => 'fas fa-server',
                'label_en' => 'DevOps / Full-Stack Engineer', 'label_fr' => 'Ingénieur DevOps / Full-Stack', 'label_ar' => 'مهندس DevOps / Full-Stack',
                'org_en' => 'Emertek-AL', 'org_fr' => 'Emertek-AL', 'org_ar' => 'Emertek-AL',
                'location_en' => 'Tunisia', 'location_fr' => 'Tunisie', 'location_ar' => 'تونس',
                'started_at' => '2025-01-01', 'ended_at' => null,
                'lane_index' => 6, 'sort_order' => 7,
            ],
        ];

        foreach ($tracks as $t) {
            DB::table('journey_tracks')->updateOrInsert(
                ['slug' => $t['slug']],
                [
                    'branch_name' => $t['branch_name'],
                    'type' => $t['type'],
                    'employment_type' => $t['employment_type'],
                    'color' => $t['color'],
                    'icon_class' => $t['icon_class'],
                    'label_en' => $t['label_en'], 'label_fr' => $t['label_fr'], 'label_ar' => $t['label_ar'],
                    'org_en' => $t['org_en'], 'org_fr' => $t['org_fr'], 'org_ar' => $t['org_ar'],
                    'location_en' => $t['location_en'], 'location_fr' => $t['location_fr'], 'location_ar' => $t['location_ar'],
                    'started_at' => $t['started_at'], 'ended_at' => $t['ended_at'],
                    'lane_index' => $t['lane_index'],
                    // No merge metaphor any more — these stay null on purpose.
                    'merges_into_id' => null, 'merged_at' => null,
                    'sort_order' => $t['sort_order'],
                    'is_active' => true,
                    'updated_at' => $now, 'created_at' => $now,
                ]
            );
        }

        // Drop paths that no longer exist — the retired git-style branches
        // ('main', 'edu/…', 'self-continuous-learning') and the folded-away
        // 'growth' path. Deleting a track cascades its milestones and their
        // technology pivot rows, so re-running never leaves orphans behind.
        DB::table('journey_tracks')
            ->whereNotIn('slug', array_column($tracks, 'slug'))
            ->delete();

        $trackId = fn (string $slug) => DB::table('journey_tracks')->where('slug', $slug)->value('id');

        // ── The eight steps ────────────────────────────────────────────────
        // `happened_at` is strictly ascending across the whole set, so the
        // frontend's chronological sort produces exactly this order, with no
        // two steps sharing a date:
        //   2021-06 · 2021-09 · 2022-07 · 2023-07 · 2023-09 · 2024-02 · 2024-09 · 2025-01
        $milestonesByTrack = [

            // ═══════════ 1 — where it started ═══════════
            'education-baccalaureate' => [
                [
                    'kind' => 'tag', 'happened_at' => '2021-06-15', 'is_highlight' => true,
                    'tag_label' => 'Baccalaureate',
                    'title_en' => 'Earned the Technical Baccalaureate',
                    'title_fr' => 'Obtention du Baccalauréat Technique',
                    'title_ar' => 'الحصول على الباكالوريا التقنية',
                    'body_en' => 'Finished secondary school on the technical track at Lycée 2 Mars 1934 in Béja — the starting point for everything that followed.',
                    'body_fr' => "Fin des études secondaires en filière technique au Lycée 2 Mars 1934 à Béja — le point de départ de tout le reste.",
                    'body_ar' => 'أكملت التعليم الثانوي في الشعبة التقنية بمعهد 2 مارس 1934 في باجة — نقطة البداية لكل ما تلاها.',
                ],
            ],

            // ═══════════ 2 — the degree (2021–2024, one step) ═══════════
            'education-license' => [
                [
                    'kind' => 'commit', 'happened_at' => '2021-09-15', 'is_highlight' => true,
                    'title_en' => 'Software Engineering degree at ISSAT Mateur',
                    'title_fr' => "Licence en génie logiciel à l'ISSAT Mateur",
                    'title_ar' => 'إجازة هندسة البرمجيات في ISSAT ماطر',
                    'body_en' => 'Three years of software engineering: algorithms, object-oriented design, databases, and cloud and microservices architecture. Graduated in 2024, with AI-Toolbox defended as the final-year project.',
                    'body_fr' => "Trois ans de génie logiciel : algorithmique, conception orientée objet, bases de données, cloud et architecture microservices. Diplômé en 2024, avec AI-Toolbox soutenu comme projet de fin d'études.",
                    'body_ar' => 'ثلاث سنوات في هندسة البرمجيات: الخوارزميات، التصميم كائني التوجّه، قواعد البيانات، السحابة وهندسة الخدمات المصغّرة. تخرّجت في 2024 بمناقشة AI-Toolbox كمشروع تخرّج.',
                    'techs' => ['Java', 'PHP', 'MySQL'],
                ],
            ],

            // ═══════════ 3 & 4 — the two internships ═══════════
            'work-internships' => [
                [
                    'kind' => 'commit', 'happened_at' => '2022-07-01',
                    'title_en' => 'Cloud engineering internship at Emertek',
                    'title_fr' => 'Stage en ingénierie cloud chez Emertek',
                    'title_ar' => 'تدريب في هندسة السحابة لدى Emertek',
                    'body_en' => 'First summer internship: an introduction to cloud infrastructure, servers, and how software actually gets deployed and kept running.',
                    'body_fr' => "Premier stage d'été : introduction à l'infrastructure cloud, aux serveurs, et à la manière dont un logiciel est réellement déployé et maintenu en service.",
                    'body_ar' => 'أول تدريب صيفي: مقدّمة إلى البنية السحابية والخوادم وكيف يُنشر البرنامج ويبقى يعمل فعليًا.',
                    'techs' => ['AWS EC2'],
                ],
                [
                    'kind' => 'commit', 'happened_at' => '2023-07-01', 'is_highlight' => true,
                    'title_en' => 'Software development internship at Leemcode',
                    'title_fr' => 'Stage en développement logiciel chez Leemcode',
                    'title_ar' => 'تدريب في تطوير البرمجيات لدى Leemcode',
                    'body_en' => 'Learned Laravel and Vue.js properly and built a small internal application with them. Also my first experience of working in a team with Git and pull requests — the toolset behind everything I have built since.',
                    'body_fr' => "J'ai appris Laravel et Vue.js pour de bon et développé une petite application interne avec. Aussi ma première expérience de travail en équipe avec Git et les pull requests — les outils derrière tout ce que j'ai construit depuis.",
                    'body_ar' => 'تعلّمت Laravel وVue.js بشكل جدّي وبنيت بهما تطبيقًا داخليًا صغيرًا. وكانت أيضًا أول تجربة عمل ضمن فريق باستخدام Git وطلبات الدمج — وهي الأدوات التي بنيت بها كل ما تلا.',
                    'techs' => ['Laravel', 'Vue.js', 'MySQL', 'Git'],
                ],
            ],

            // ═══════════ 5 — freelance, as one outcome ═══════════
            'freelance' => [
                [
                    // Tolab, found on Mostaql, was the first — Nov 2023, four
                    // months after the Leemcode internship taught the stack.
                    'kind' => 'commit', 'happened_at' => '2023-11-30', 'is_highlight' => true,
                    'title_en' => 'Started freelancing — and shipped five production platforms',
                    'title_fr' => 'Début du freelance — cinq plateformes livrées en production',
                    'title_ar' => 'بدأت العمل الحر — وأطلقت خمس منصّات في الإنتاج',
                    'body_en' => 'Found my first paying client on Mostaql while still studying, and built Tolab for them. It grew into five live platforms — real estate, products, education and portfolios — each one designed, built and delivered end to end, alone.',
                    'body_fr' => "J'ai trouvé mon premier client payant sur Mostaql, encore étudiant, et j'ai développé Tolab pour lui. C'est devenu cinq plateformes en ligne — immobilier, produits, éducation et portfolios — chacune conçue, développée et livrée de bout en bout, en solo.",
                    'body_ar' => 'وجدت أول عميل يدفع على Mostaql وأنا لا أزال أدرس، وبنيت له Tolab. تحوّل ذلك إلى خمس منصّات على الإنترنت — عقارات ومنتجات وتعليم وبورتفوليو — صمّمت وبنيت وسلّمت كلًّا منها بالكامل بمفردي.',
                    'project' => 'boonapp',
                    'techs' => ['Laravel', 'Vue.js', 'TypeScript', 'MySQL', 'PostgreSQL'],
                ],
            ],

            // ═══════════ 6 — the capstone product ═══════════
            'capstone' => [
                [
                    'kind' => 'commit', 'happened_at' => '2024-02-01', 'is_highlight' => true,
                    'title_en' => 'Built AI-Toolbox as my final-year project',
                    'title_fr' => "Développement d'AI-Toolbox comme projet de fin d'études",
                    'title_ar' => 'بناء AI-Toolbox كمشروع تخرّج',
                    'body_en' => 'An all-in-one AI web app: one subscription lets a user generate images, text and more from several AI models. Built full-stack and owned from requirements to delivery.',
                    'body_fr' => "Une application web IA tout-en-un : un seul abonnement permet de générer images, textes et plus via plusieurs modèles d'IA. Développée entièrement en full-stack et pilotée des besoins à la livraison.",
                    'body_ar' => 'تطبيق ويب شامل للذكاء الاصطناعي: اشتراك واحد يتيح توليد الصور والنصوص وغيرها من عدّة نماذج. بنيته كاملًا full-stack وتولّيته من المتطلبات إلى التسليم.',
                    'project' => 'ai-toolbox',
                    'techs' => ['Laravel', 'Vue.js', 'PHP', 'MySQL'],
                ],
            ],

            // ═══════════ 7 — the specialisation ═══════════
            'education-engineering' => [
                [
                    'kind' => 'commit', 'happened_at' => '2024-09-15', 'is_highlight' => true,
                    'title_en' => 'Started AI & Data Science engineering at Iteams',
                    'title_fr' => 'Début du cycle ingénieur IA & Data Science à Iteams',
                    'title_ar' => 'بدء هندسة الذكاء الاصطناعي وعلوم البيانات في Iteams',
                    'body_en' => 'Back to school for an engineering degree while working — deep learning, NLP, big data with Spark and Hadoop, and MLOps. Graduating 2027, moving from building applications to building systems that learn.',
                    'body_fr' => "Retour aux études pour un diplôme d'ingénieur tout en travaillant — deep learning, NLP, big data avec Spark et Hadoop, et MLOps. Diplôme en 2027 : passer de la création d'applications à celle de systèmes qui apprennent.",
                    'body_ar' => 'عدت إلى الدراسة لشهادة هندسية مع العمل — التعلّم العميق ومعالجة اللغة الطبيعية والبيانات الضخمة بـ Spark وHadoop وMLOps. التخرّج في 2027، انتقالًا من بناء التطبيقات إلى بناء أنظمة تتعلّم.',
                    'techs' => ['Python', 'Spark', 'Hadoop', 'Deep Learning', 'NLP', 'MLOps'],
                ],
            ],

            // ═══════════ 8 — where it is now ═══════════
            'work-emertek-al' => [
                [
                    'kind' => 'head', 'happened_at' => '2025-01-15', 'is_highlight' => true,
                    'title_en' => 'DevOps / Full-Stack Engineer at Emertek-AL',
                    'title_fr' => "Ingénieur DevOps / Full-Stack chez Emertek-AL",
                    'title_ar' => 'مهندس DevOps / Full-Stack في Emertek-AL',
                    'body_en' => 'My first professional engineering role, working across the whole delivery pipeline instead of only writing features: CI/CD, containerised deployments, AWS infrastructure and monitoring — plus full-stack work on client products.',
                    'body_fr' => "Mon premier poste d'ingénieur, sur toute la chaîne de livraison plutôt que sur le seul développement de fonctionnalités : CI/CD, déploiements conteneurisés, infrastructure AWS et supervision — ainsi que du full-stack sur les produits clients.",
                    'body_ar' => 'أول وظيفة هندسية لي، أعمل على كامل سلسلة التسليم لا على كتابة الميزات فقط: CI/CD، والنشر بالحاويات، وبنية AWS، والمراقبة — إلى جانب عمل full-stack على منتجات العملاء.',
                    'techs' => ['Docker', 'AWS EC2', 'Jenkins', 'GitHub Actions', 'Kubernetes', 'Grafana'],
                ],
            ],
        ];

        foreach ($milestonesByTrack as $trackSlug => $rows) {
            $tid = $trackId($trackSlug);
            if (! $tid) {
                continue;
            }

            // Clear + reinsert (deleting a milestone cascades its tech pivot).
            DB::table('journey_milestones')->where('track_id', $tid)->delete();

            foreach (array_values($rows) as $i => $m) {
                $projectId = ! empty($m['project'])
                    ? DB::table('projects')->where('slug', $m['project'])->value('id')
                    : null;

                $milestoneId = DB::table('journey_milestones')->insertGetId([
                    'track_id' => $tid,
                    'kind' => $m['kind'],
                    // Column is NOT NULL; nothing on the frontend displays it.
                    'commit_hash' => substr(sha1($trackSlug.'|'.$m['title_en']), 0, 7),
                    'title_en' => $m['title_en'], 'title_fr' => $m['title_fr'], 'title_ar' => $m['title_ar'],
                    'body_en' => $m['body_en'] ?? null, 'body_fr' => $m['body_fr'] ?? null, 'body_ar' => $m['body_ar'] ?? null,
                    'tag_label' => $m['tag_label'] ?? null,
                    'happened_at' => $m['happened_at'],
                    'project_id' => $projectId,
                    'link_url' => $m['link'] ?? null,
                    'is_highlight' => $m['is_highlight'] ?? false,
                    'sort_order' => $i,
                    'is_active' => true,
                    'updated_at' => $now, 'created_at' => $now,
                ]);

                foreach (array_values($m['techs'] ?? []) as $ti => $techName) {
                    $techId = DB::table('technologies')->where('name', $techName)->value('id');
                    if ($techId) {
                        DB::table('journey_milestone_technologies')->insert([
                            'milestone_id' => $milestoneId,
                            'technology_id' => $techId,
                            'sort_order' => $ti,
                        ]);
                    }
                }
            }
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * The Journey ("git log --graph --all"): career branches (tracks) and the
 * commits on them (milestones), in all three languages.
 *
 * Idempotent: the section + tracks are upserted by slug; milestones are cleared
 * per track and re-inserted (which cascades the tech pivot). Commit-message
 * prefixes (feat:/init:/chore:/merge:/tag:) are kept untranslated as a code
 * aesthetic; the rest of each title is translated.
 *
 * `commit_hash` is computed here (substr(sha1(slug|title_en),0,7)) to match the
 * JourneyMilestone saving hook, because this seeder uses the query builder and
 * DatabaseSeeder mutes model events.
 */
class JourneySeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        // ── Section (defaults cover badges/heading/next_label) ─────────────
        DB::table('journey_section')->updateOrInsert(
            ['id' => 1],
            [
                'subheading_en' => '6+ years of continuous commits · parallel branches · zero gaps.',
                'subheading_fr' => "6+ ans de commits continus · branches parallèles · zéro interruption.",
                'subheading_ar' => 'أكثر من 6 سنوات من الـ commits المتواصلة · فروع متوازية · بلا انقطاع.',
                'updated_at' => $now,
                'created_at' => $now,
            ]
        );

        // ── Tracks (branches) — insert first, then wire merge FKs ──────────
        $tracks = [
            [
                'slug' => 'main', 'branch_name' => 'main', 'type' => 'main', 'color' => null,
                'icon_class' => 'fas fa-code-branch',
                'label_en' => 'main', 'label_fr' => 'main', 'label_ar' => 'main',
                'org_en' => null, 'org_fr' => null, 'org_ar' => null,
                'started_at' => '2020-09-01', 'ended_at' => null, 'lane_index' => 0,
                'merges' => null, 'merged_at' => null, 'sort_order' => 0,
            ],
            [
                'slug' => 'edu-software-engineering', 'branch_name' => 'edu/software-engineering',
                'type' => 'education', 'color' => null, 'icon_class' => 'fas fa-graduation-cap',
                'label_en' => 'Software Engineering Degree', 'label_fr' => 'Diplôme en génie logiciel', 'label_ar' => 'إجازة في هندسة البرمجيات',
                'org_en' => 'ISSAT Mateur', 'org_fr' => 'ISSAT Mateur', 'org_ar' => 'المعهد العالي للعلوم التطبيقية والتكنولوجيا بماطر',
                'location_en' => 'Mateur, Tunisia', 'location_fr' => 'Mateur, Tunisie', 'location_ar' => 'ماطر، تونس',
                'started_at' => '2020-09-01', 'ended_at' => '2023-06-30', 'lane_index' => 1,
                'merges' => 'main', 'merged_at' => '2023-06-30', 'sort_order' => 1,
            ],
            [
                'slug' => 'freelance-platforms', 'branch_name' => 'freelance/platforms',
                'type' => 'freelance', 'employment_type' => 'freelance', 'color' => null, 'icon_class' => 'fas fa-briefcase',
                'label_en' => 'Freelance Platforms', 'label_fr' => 'Plateformes en freelance', 'label_ar' => 'منصّات كمستقل',
                'org_en' => 'Clients', 'org_fr' => 'Clients', 'org_ar' => 'عملاء',
                'location_en' => 'Tunisia · Remote', 'location_fr' => 'Tunisie · À distance', 'location_ar' => 'تونس · عن بُعد',
                'started_at' => '2021-06-01', 'ended_at' => null, 'lane_index' => 2,
                'merges' => null, 'merged_at' => null, 'sort_order' => 2,
            ],
            [
                'slug' => 'edu-ai-data-science', 'branch_name' => 'edu/ai-data-science',
                'type' => 'education', 'color' => null, 'icon_class' => 'fas fa-brain',
                'label_en' => 'AI & Data Science Engineering', 'label_fr' => 'Ingénierie IA & Data Science', 'label_ar' => 'هندسة الذكاء الاصطناعي وعلوم البيانات',
                'org_en' => 'Iteams', 'org_fr' => 'Iteams', 'org_ar' => 'Iteams',
                'location_en' => 'Tunisia', 'location_fr' => 'Tunisie', 'location_ar' => 'تونس',
                'started_at' => '2023-09-01', 'ended_at' => null, 'lane_index' => 3,
                'merges' => null, 'merged_at' => null, 'sort_order' => 3,
            ],
            [
                'slug' => 'work-devops-engineer', 'branch_name' => 'work/devops-engineer',
                'type' => 'work', 'employment_type' => 'full_time', 'color' => null, 'icon_class' => 'fas fa-server',
                'label_en' => 'DevOps / Full-Stack Engineer', 'label_fr' => 'Ingénieur DevOps / Full-Stack', 'label_ar' => 'مهندس DevOps / Full-Stack',
                'org_en' => 'Emertek-AL', 'org_fr' => 'Emertek-AL', 'org_ar' => 'Emertek-AL',
                'location_en' => 'Tunisia', 'location_fr' => 'Tunisie', 'location_ar' => 'تونس',
                'started_at' => '2025-01-01', 'ended_at' => null, 'lane_index' => 4,
                'merges' => null, 'merged_at' => null, 'sort_order' => 4,
            ],
            [
                'slug' => 'self-continuous-learning', 'branch_name' => 'self/continuous-learning',
                'type' => 'self', 'color' => null, 'icon_class' => 'fas fa-bolt',
                'label_en' => 'Continuous Learning', 'label_fr' => 'Apprentissage continu', 'label_ar' => 'التعلّم المستمر',
                'org_en' => null, 'org_fr' => null, 'org_ar' => null,
                'started_at' => '2020-09-01', 'ended_at' => null, 'lane_index' => 5,
                'merges' => null, 'merged_at' => null, 'sort_order' => 5,
            ],
            [
                'slug' => 'work-emertek-intern', 'branch_name' => 'work/cloud-intern',
                'type' => 'work', 'employment_type' => 'internship', 'color' => null, 'icon_class' => 'fas fa-cloud',
                'label_en' => 'Cloud Engineering Intern', 'label_fr' => 'Stagiaire ingénierie cloud', 'label_ar' => 'متدرّب هندسة سحابية',
                'org_en' => 'Emertek', 'org_fr' => 'Emertek', 'org_ar' => 'Emertek',
                'location_en' => 'Tunisia', 'location_fr' => 'Tunisie', 'location_ar' => 'تونس',
                'started_at' => '2022-06-01', 'ended_at' => '2022-08-31', 'lane_index' => 6,
                'merges' => null, 'merged_at' => null, 'sort_order' => 6,
            ],
            [
                'slug' => 'work-leemcode-intern', 'branch_name' => 'work/software-intern',
                'type' => 'work', 'employment_type' => 'internship', 'color' => null, 'icon_class' => 'fas fa-laptop-code',
                'label_en' => 'Software Development Intern', 'label_fr' => 'Stagiaire développement logiciel', 'label_ar' => 'متدرّب تطوير برمجيات',
                'org_en' => 'Leemcode', 'org_fr' => 'Leemcode', 'org_ar' => 'Leemcode',
                'location_en' => 'Tunisia', 'location_fr' => 'Tunisie', 'location_ar' => 'تونس',
                'started_at' => '2023-06-01', 'ended_at' => '2023-08-31', 'lane_index' => 7,
                'merges' => null, 'merged_at' => null, 'sort_order' => 7,
            ],
        ];

        foreach ($tracks as $t) {
            DB::table('journey_tracks')->updateOrInsert(
                ['slug' => $t['slug']],
                [
                    'branch_name' => $t['branch_name'], 'type' => $t['type'], 'color' => $t['color'],
                    'employment_type' => $t['employment_type'] ?? null,
                    'icon_class' => $t['icon_class'],
                    'label_en' => $t['label_en'], 'label_fr' => $t['label_fr'], 'label_ar' => $t['label_ar'],
                    'org_en' => $t['org_en'], 'org_fr' => $t['org_fr'], 'org_ar' => $t['org_ar'],
                    'location_en' => $t['location_en'] ?? null, 'location_fr' => $t['location_fr'] ?? null, 'location_ar' => $t['location_ar'] ?? null,
                    'started_at' => $t['started_at'], 'ended_at' => $t['ended_at'],
                    'lane_index' => $t['lane_index'], 'merged_at' => $t['merged_at'],
                    'sort_order' => $t['sort_order'], 'is_active' => true,
                    'updated_at' => $now, 'created_at' => $now,
                ]
            );
        }

        $trackId = fn (string $slug) => DB::table('journey_tracks')->where('slug', $slug)->value('id');

        // Wire merge FKs now that every track has an id.
        foreach ($tracks as $t) {
            if ($t['merges']) {
                DB::table('journey_tracks')->where('slug', $t['slug'])
                    ->update(['merges_into_id' => $trackId($t['merges'])]);
            }
        }

        // ── Milestones (commits) per branch ────────────────────────────────
        $milestonesByTrack = [
            'main' => [
                [
                    'kind' => 'commit', 'happened_at' => '2020-09-01', 'is_highlight' => true,
                    'title_en' => 'init: chose software engineering',
                    'title_fr' => 'init: choix du génie logiciel',
                    'title_ar' => 'init: اخترتُ هندسة البرمجيات',
                    'body_en' => 'The first commit. Everything branches from here.',
                    'body_fr' => "Le premier commit. Tout part d'ici.",
                    'body_ar' => 'أول commit. كل شيء يتفرّع من هنا.',
                ],
                [
                    'kind' => 'head', 'happened_at' => '2026-07-01', 'is_highlight' => true,
                    'title_en' => 'HEAD → main',
                    'title_fr' => 'HEAD → main',
                    'title_ar' => 'HEAD → main',
                    'body_en' => 'You are here.',
                    'body_fr' => 'Vous êtes ici.',
                    'body_ar' => 'أنت هنا.',
                ],
            ],
            'edu-software-engineering' => [
                [
                    'kind' => 'commit', 'happened_at' => '2021-06-01',
                    'title_en' => 'feat: full-stack foundations (web/desktop/mobile)',
                    'title_fr' => 'feat: bases full-stack (web/bureau/mobile)',
                    'title_ar' => 'feat: أسس full-stack (ويب/سطح المكتب/موبايل)',
                    'techs' => ['Vue.js', 'PHP'],
                ],
                [
                    'kind' => 'commit', 'happened_at' => '2022-06-01',
                    'title_en' => 'feat: algorithms, OOP, databases, architecture',
                    'title_fr' => 'feat: algorithmique, POO, bases de données, architecture',
                    'title_ar' => 'feat: الخوارزميات، البرمجة الكائنية، قواعد البيانات، الهندسة المعمارية',
                    'techs' => ['MySQL'],
                ],
                [
                    'kind' => 'tag', 'happened_at' => '2023-06-30', 'is_highlight' => true,
                    'tag_label' => 'v1.0-bachelor',
                    'title_en' => 'merge: software engineering degree → main',
                    'title_fr' => 'merge: diplôme en génie logiciel → main',
                    'title_ar' => 'merge: إجازة هندسة البرمجيات → main',
                    'body_en' => 'Released v1.0-bachelor. Foundations shipped into main.',
                    'body_fr' => 'Version v1.0-bachelor publiée. Les bases fusionnées dans main.',
                    'body_ar' => 'إصدار v1.0-bachelor. الأسس اندمجت في main.',
                ],
            ],
            'freelance-platforms' => [
                [
                    'kind' => 'commit', 'happened_at' => '2021-09-01', 'is_highlight' => true,
                    'title_en' => 'feat: real-estate platform shipped',
                    'title_fr' => 'feat: plateforme immobilière livrée',
                    'title_ar' => 'feat: إطلاق منصّة عقارية',
                    'body_en' => 'First client platform delivered end-to-end, solo.',
                    'body_fr' => "Première plateforme client livrée de bout en bout, en solo.",
                    'body_ar' => 'أول منصّة عميل سُلّمت بالكامل، بمفردي.',
                    'project' => 'boonapp',
                    'techs' => ['Vue.js', 'Laravel', 'MySQL'],
                ],
                [
                    'kind' => 'commit', 'happened_at' => '2022-05-01',
                    'title_en' => 'feat: tiny-houses platform',
                    'title_fr' => 'feat: plateforme de tiny-houses',
                    'title_ar' => 'feat: منصّة المنازل الصغيرة',
                    'project' => 'ecoboxfactory',
                    'techs' => ['Vue.js', 'Laravel'],
                ],
                [
                    'kind' => 'commit', 'happened_at' => '2023-02-01',
                    'title_en' => 'feat: educational platform',
                    'title_fr' => 'feat: plateforme éducative',
                    'title_ar' => 'feat: منصّة تعليمية',
                    'project' => 'tenja7',
                    'techs' => ['Laravel', 'PHP', 'MySQL'],
                ],
                [
                    'kind' => 'commit', 'happened_at' => '2023-10-01',
                    'title_en' => 'chore: full SDLC solo — requirements → SEO → deploy',
                    'title_fr' => 'chore: cycle de vie complet en solo — besoins → SEO → déploiement',
                    'title_ar' => 'chore: دورة تطوير كاملة بمفردي — المتطلبات → SEO → النشر',
                ],
            ],
            'edu-ai-data-science' => [
                [
                    'kind' => 'commit', 'happened_at' => '2023-09-01', 'is_highlight' => true,
                    'title_en' => 'init: AI & Data Science engineering degree',
                    'title_fr' => "init: diplôme d'ingénieur IA & Data Science",
                    'title_ar' => 'init: هندسة الذكاء الاصطناعي وعلوم البيانات',
                    'body_en' => 'Branched ahead — the next release is already in progress.',
                    'body_fr' => 'Branche en avance — la prochaine version est déjà en cours.',
                    'body_ar' => 'فرع متقدّم — الإصدار القادم قيد التنفيذ بالفعل.',
                ],
                [
                    'kind' => 'commit', 'happened_at' => '2024-03-01',
                    'title_en' => 'feat: ML/DL, NLP, computer vision',
                    'title_fr' => 'feat: ML/DL, NLP, vision par ordinateur',
                    'title_ar' => 'feat: تعلّم آلي/عميق، معالجة اللغة الطبيعية، رؤية حاسوبية',
                ],
                [
                    'kind' => 'commit', 'happened_at' => '2024-10-01',
                    'title_en' => 'feat: big data — Hadoop, Spark',
                    'title_fr' => 'feat: big data — Hadoop, Spark',
                    'title_ar' => 'feat: البيانات الضخمة — Hadoop, Spark',
                ],
                [
                    'kind' => 'commit', 'happened_at' => '2025-05-01',
                    'title_en' => 'feat: MLOps foundations',
                    'title_fr' => 'feat: bases MLOps',
                    'title_ar' => 'feat: أسس MLOps',
                    'techs' => ['Docker'],
                ],
                [
                    'kind' => 'tag', 'happened_at' => '2026-06-01',
                    'tag_label' => 'v2.0-engineer [WIP]',
                    'title_en' => 'tag: v2.0-engineer [WIP]',
                    'title_fr' => 'tag: v2.0-engineer [WIP]',
                    'title_ar' => 'tag: v2.0-engineer [WIP]',
                    'body_en' => 'Release candidate — still ahead of the now-line.',
                    'body_fr' => 'Version candidate — encore en avance sur la ligne du présent.',
                    'body_ar' => 'إصدار مرشّح — لا يزال متقدّمًا على خط الحاضر.',
                ],
            ],
            'work-devops-engineer' => [
                [
                    'kind' => 'commit', 'happened_at' => '2025-01-01', 'is_highlight' => true,
                    'title_en' => 'init: DevOps Engineer — production',
                    'title_fr' => 'init: Ingénieur DevOps — production',
                    'title_ar' => 'init: مهندس DevOps — الإنتاج',
                    'body_en' => 'One of four active branches. Density, not seniority.',
                    'body_fr' => 'Une des quatre branches actives. La densité, pas la séniorité.',
                    'body_ar' => 'واحد من أربعة فروع نشطة. الكثافة، لا الأقدمية.',
                ],
                [
                    'kind' => 'commit', 'happened_at' => '2025-03-01',
                    'title_en' => 'feat: CI/CD — Jenkins, GitHub Actions',
                    'title_fr' => 'feat: CI/CD — Jenkins, GitHub Actions',
                    'title_ar' => 'feat: CI/CD — Jenkins, GitHub Actions',
                    'techs' => ['Docker'],
                ],
                [
                    'kind' => 'commit', 'happened_at' => '2025-06-01',
                    'title_en' => 'feat: AWS infra — EC2, S3, CloudFront',
                    'title_fr' => 'feat: infra AWS — EC2, S3, CloudFront',
                    'title_ar' => 'feat: بنية AWS — EC2, S3, CloudFront',
                    'techs' => ['Docker'],
                ],
                [
                    'kind' => 'commit', 'happened_at' => '2025-09-01',
                    'title_en' => 'feat: monitoring — Grafana, Prometheus',
                    'title_fr' => 'feat: supervision — Grafana, Prometheus',
                    'title_ar' => 'feat: مراقبة — Grafana, Prometheus',
                ],
                [
                    'kind' => 'merge', 'happened_at' => '2025-12-01',
                    'title_en' => 'merge: dev × ops mindset → main',
                    'title_fr' => "merge: état d'esprit dev × ops → main",
                    'title_ar' => 'merge: عقلية dev × ops → main',
                ],
            ],
            'self-continuous-learning' => [
                [
                    'kind' => 'commit', 'happened_at' => '2024-01-01',
                    'title_en' => 'feat: AI-assisted development workflow',
                    'title_fr' => "feat: flux de développement assisté par IA",
                    'title_ar' => 'feat: سير عمل تطوير بمساعدة الذكاء الاصطناعي',
                ],
                [
                    'kind' => 'commit', 'happened_at' => '2024-08-01',
                    'title_en' => 'feat: analytics & BI — GTM, Pixel, dashboards',
                    'title_fr' => 'feat: analytics & BI — GTM, Pixel, tableaux de bord',
                    'title_ar' => 'feat: تحليلات وذكاء أعمال — GTM, Pixel, لوحات',
                ],
            ],
            'work-emertek-intern' => [
                [
                    'kind' => 'commit', 'happened_at' => '2022-07-01',
                    'title_en' => 'feat: cloud engineering fundamentals & infrastructure basics',
                    'title_fr' => 'feat: fondamentaux du cloud & bases infrastructure',
                    'title_ar' => 'feat: أساسيات هندسة السحابة والبنية التحتية',
                ],
            ],
            'work-leemcode-intern' => [
                [
                    'kind' => 'commit', 'happened_at' => '2023-07-01',
                    'title_en' => 'feat: hands-on application development',
                    'title_fr' => 'feat: développement applicatif pratique',
                    'title_ar' => 'feat: تطوير تطبيقات عملي',
                ],
            ],
        ];

        foreach ($milestonesByTrack as $trackSlug => $rows) {
            $tid = $trackId($trackSlug);
            if (! $tid) {
                continue;
            }

            // Clear + reinsert (deleting a milestone cascades its tech pivot at DB level).
            DB::table('journey_milestones')->where('track_id', $tid)->delete();

            foreach (array_values($rows) as $i => $m) {
                $projectId = ! empty($m['project'])
                    ? DB::table('projects')->where('slug', $m['project'])->value('id')
                    : null;

                $milestoneId = DB::table('journey_milestones')->insertGetId([
                    'track_id' => $tid,
                    'kind' => $m['kind'],
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

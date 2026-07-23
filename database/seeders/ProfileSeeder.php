<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Profile data from the master profile that the base seed didn't cover:
 * skill buckets (technology_groups) + the full grouped tech list, spoken
 * languages, and personal interests.
 *
 * Runs after PortfolioSeeder so the technologies seeded by HomeSeeder already
 * exist — here we (re)key them into groups and add the ones that were missing.
 * Idempotent: groups upsert by slug, technologies by name, the rest by name_en.
 */
class ProfileSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        // ── Technology groups (skill buckets) ───────────────────────────────
        $groups = [
            ['programming-languages', 'Programming Languages', 'Langages de programmation', 'لغات البرمجة', 1],
            ['frameworks', 'Frameworks & Libraries', 'Frameworks & bibliothèques', 'أطر ومكتبات', 2],
            ['databases', 'Databases', 'Bases de données', 'قواعد البيانات', 3],
            ['big-data', 'Big Data', 'Big Data', 'البيانات الضخمة', 4],
            ['devops-cloud', 'DevOps & Cloud', 'DevOps & Cloud', 'DevOps والسحابة', 5],
            ['ai-data-science', 'AI / Data Science', 'IA / Data Science', 'الذكاء الاصطناعي وعلوم البيانات', 6],
        ];
        foreach ($groups as [$slug, $en, $fr, $ar, $order]) {
            DB::table('technology_groups')->updateOrInsert(
                ['slug' => $slug],
                ['name_en' => $en, 'name_fr' => $fr, 'name_ar' => $ar, 'sort_order' => $order, 'is_active' => true, 'updated_at' => $now, 'created_at' => $now]
            );
        }
        $gid = fn (string $slug) => DB::table('technology_groups')->where('slug', $slug)->value('id');

        // ── Technologies — [name, group, proficiency, icon_class, color] ─────
        $techs = [
            // Programming languages
            ['Java', 'programming-languages', 'proficient', 'devicon-java-plain', '#007396'],
            ['Python', 'programming-languages', 'core', 'devicon-python-plain', '#3776AB'],
            ['PHP', 'programming-languages', 'core', 'devicon-php-plain', '#777BB4'],
            ['C', 'programming-languages', 'familiar', 'devicon-c-plain', '#A8B9CC'],
            ['C++', 'programming-languages', 'familiar', 'devicon-cplusplus-plain', '#00599C'],
            ['JavaScript', 'programming-languages', 'core', 'devicon-javascript-plain', '#F7DF1E'],
            ['TypeScript', 'programming-languages', 'core', 'devicon-typescript-plain', '#3178C6'],
            ['HTML', 'programming-languages', 'proficient', 'devicon-html5-plain', '#E34F26'],
            ['CSS', 'programming-languages', 'proficient', 'devicon-css3-plain', '#1572B6'],
            // Frameworks & libraries
            ['Spring Boot', 'frameworks', 'proficient', 'devicon-spring-plain', '#6DB33F'],
            ['JavaFX', 'frameworks', 'familiar', 'devicon-java-plain', '#007396'],
            ['Laravel', 'frameworks', 'core', 'devicon-laravel-plain', '#FF2D20'],
            ['Vue.js', 'frameworks', 'core', 'devicon-vuejs-plain', '#42B883'],
            ['React', 'frameworks', 'proficient', 'devicon-react-original', '#61DAFB'],
            ['Node.js', 'frameworks', 'proficient', 'devicon-nodejs-plain', '#339933'],
            ['Express', 'frameworks', 'proficient', 'devicon-express-original', '#000000'],
            ['Django', 'frameworks', 'familiar', 'devicon-django-plain', '#092E20'],
            ['Flask', 'frameworks', 'familiar', 'devicon-flask-original', '#000000'],
            ['Fastify', 'frameworks', 'familiar', 'devicon-fastify-plain', '#000000'],
            ['Sass', 'frameworks', 'proficient', 'devicon-sass-original', '#CC6699'],
            ['Tailwind CSS', 'frameworks', 'core', 'devicon-tailwindcss-plain', '#06B6D4'],
            // Databases
            ['MySQL', 'databases', 'core', 'devicon-mysql-plain', '#4479A1'],
            ['PostgreSQL', 'databases', 'proficient', 'devicon-postgresql-plain', '#4169E1'],
            ['MongoDB', 'databases', 'proficient', 'devicon-mongodb-plain', '#47A248'],
            ['Redis', 'databases', 'proficient', 'devicon-redis-plain', '#DC382D'],
            // Big data
            ['Hadoop', 'big-data', 'familiar', 'devicon-hadoop-plain', '#66CCFF'],
            ['Spark', 'big-data', 'familiar', 'devicon-apachespark-plain', '#E25A1C'],
            // DevOps & cloud
            ['Jira', 'devops-cloud', 'proficient', 'devicon-jira-plain', '#0052CC'],
            ['Trello', 'devops-cloud', 'proficient', 'devicon-trello-plain', '#0052CC'],
            ['VS Code', 'devops-cloud', 'core', 'devicon-vscode-plain', '#007ACC'],
            ['Git', 'devops-cloud', 'core', 'devicon-git-plain', '#F05032'],
            ['GitHub', 'devops-cloud', 'core', 'devicon-github-original', '#181717'],
            ['GitLab', 'devops-cloud', 'proficient', 'devicon-gitlab-plain', '#FC6D26'],
            ['npm', 'devops-cloud', 'proficient', 'devicon-npm-original-wordmark', '#CB3837'],
            ['Jenkins', 'devops-cloud', 'proficient', 'devicon-jenkins-plain', '#D24939'],
            ['GitHub Actions', 'devops-cloud', 'proficient', 'devicon-githubactions-plain', '#2088FF'],
            ['GitLab CI', 'devops-cloud', 'proficient', 'devicon-gitlab-plain', '#FC6D26'],
            ['Docker', 'devops-cloud', 'core', 'devicon-docker-plain', '#2496ED'],
            ['AWS EC2', 'devops-cloud', 'core', 'devicon-amazonwebservices-plain-wordmark', '#FF9900'],
            ['Kubernetes', 'devops-cloud', 'familiar', 'devicon-kubernetes-plain', '#326CE5'],
            ['Grafana', 'devops-cloud', 'proficient', 'devicon-grafana-original', '#F46800'],
            ['Prometheus', 'devops-cloud', 'proficient', 'devicon-prometheus-original', '#E6522C'],
            // AI / data science
            ['Deep Learning', 'ai-data-science', 'familiar', null, null],
            ['NLP', 'ai-data-science', 'familiar', null, null],
            ['Data Analytics', 'ai-data-science', 'proficient', null, null],
            ['MapReduce', 'ai-data-science', 'familiar', null, null],
            ['MLOps', 'ai-data-science', 'familiar', null, null],
        ];
        // A curated handful shown on the home-page tech strip.
        $featured = ['Laravel', 'Vue.js', 'TypeScript', 'Docker', 'AWS EC2', 'Python', 'MySQL', 'Git'];
        $order = 0;
        foreach ($techs as [$name, $group, $prof, $icon, $color]) {
            DB::table('technologies')->updateOrInsert(
                ['name' => $name],
                [
                    'group_id' => $gid($group),
                    'proficiency' => $prof,
                    'icon_class' => $icon,
                    'color' => $color,
                    'is_featured' => in_array($name, $featured, true),
                    'sort_order' => $order++,
                    'updated_at' => $now,
                    'created_at' => $now,
                ]
            );
        }

        // ── Spoken languages ────────────────────────────────────────────────
        $languages = [
            ['Arabic', 'Arabe', 'العربية', 'native', 'Native', 'Langue maternelle', 'اللغة الأم', 1],
            ['French', 'Français', 'الفرنسية', 'b1', 'Improving; goal B2+', 'En progression ; objectif B2+', 'قيد التحسّن؛ الهدف B2+', 2],
            ['English', 'Anglais', 'الإنجليزية', 'b1', 'Working proficiency', 'Niveau professionnel', 'كفاءة عملية', 3],
        ];
        foreach ($languages as [$en, $fr, $ar, $level, $nen, $nfr, $nar, $ord]) {
            DB::table('languages')->updateOrInsert(
                ['name_en' => $en],
                ['name_fr' => $fr, 'name_ar' => $ar, 'level' => $level, 'note_en' => $nen, 'note_fr' => $nfr, 'note_ar' => $nar, 'sort_order' => $ord, 'is_active' => true, 'updated_at' => $now, 'created_at' => $now]
            );
        }

        // ── Interests ─────────────────────────────────────────────────────────
        $interests = [
            ['Reading', 'Lecture', 'القراءة', 'fas fa-book-open', 1],
            ['Video games', 'Jeux vidéo', 'ألعاب الفيديو', 'fas fa-gamepad', 2],
            ['Sport', 'Sport', 'الرياضة', 'fas fa-dumbbell', 3],
            ['Movies', 'Cinéma', 'الأفلام', 'fas fa-film', 4],
            ['Traveling', 'Voyages', 'السفر', 'fas fa-plane', 5],
        ];
        foreach ($interests as [$en, $fr, $ar, $icon, $ord]) {
            DB::table('interests')->updateOrInsert(
                ['name_en' => $en],
                ['name_fr' => $fr, 'name_ar' => $ar, 'icon_class' => $icon, 'sort_order' => $ord, 'is_active' => true, 'updated_at' => $now, 'created_at' => $now]
            );
        }
    }
}

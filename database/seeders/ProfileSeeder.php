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
            ['Java', 'programming-languages', 'proficient', 'devicon-java-plain', '#007396', '/assets/technologies/icons8-java-48.png'],//
            ['Python', 'programming-languages', 'core', 'devicon-python-plain', '#3776AB', '/assets/technologies/icons8-python-48.png'],//
            ['PHP', 'programming-languages', 'core', 'devicon-php-plain', '#777BB4', '/assets/technologies/icons8-php-48.png'],//
            ['C', 'programming-languages', 'familiar', 'devicon-c-plain', '#A8B9CC', '/assets/technologies/icons8-c-programming-48.png'],//
            ['C++', 'programming-languages', 'familiar', 'devicon-cplusplus-plain', '#00599C', '/assets/technologies/icons8-c-48.png'],//
            ['JavaScript', 'programming-languages', 'core', 'devicon-javascript-plain', '#F7DF1E', '/assets/technologies/icons8-javascript-48.png'],//
            ['TypeScript', 'programming-languages', 'core', 'devicon-typescript-plain', '#3178C6', '/assets/technologies/icons8-typescript-48.png'],//
            // Frameworks & libraries
            ['Spring Boot', 'frameworks', 'proficient', 'devicon-spring-plain', '#6DB33F', '/assets/technologies/icons8-spring-boot-40.png'],//
            ['JavaFX', 'frameworks', 'familiar', 'devicon-java-plain', '#007396', '/assets/technologies/JavaFX_Logo.png'],//
            ['Laravel', 'frameworks', 'core', 'devicon-laravel-plain', '#FF2D20', '/assets/technologies/icons8-laravel-64.png'],//
            ['Vue.js', 'frameworks', 'core', 'devicon-vuejs-plain', '#42B883', '/assets/technologies/icons8-vue-js-48.png'],//
            ['React', 'frameworks', 'proficient', 'devicon-react-original', '#61DAFB', '/assets/technologies/icons8-react-48.png'],//
            ['Node.js', 'frameworks', 'proficient', 'devicon-nodejs-plain', '#339933', '/assets/technologies/icons8-node-js-48.png'],//
            ['Express', 'frameworks', 'proficient', 'devicon-express-original', '#000000', '/assets/technologies/icons8-express-js-50.png'],//
            ['Nuxt Js', 'frameworks', 'proficient', 'devicon-nuxtjs-plain', '#00DC82', '/assets/technologies/icons8-nuxt-js-48.png'],//
            ['Django', 'frameworks', 'familiar', 'devicon-django-plain', '#092E20', '/assets/technologies/icons8-django-48.png'],//
            ['Flask', 'frameworks', 'familiar', 'devicon-flask-original', '#000000', '/assets/technologies/icons8-flask-50.png'],//
            ['Fastify', 'frameworks', 'familiar', 'devicon-fastify-plain', '#000000', '/assets/technologies/Fastify.png'],
            ['Sass', 'frameworks', 'proficient', 'devicon-sass-original', '#CC6699', '/assets/technologies/icons8-sass-48.png'],//
            ['Tailwind CSS', 'frameworks', 'core', 'devicon-tailwindcss-plain', '#06B6D4', '/assets/technologies/icons8-tailwind-css-48.png'],//
            // Databases
            ['MySQL', 'databases', 'core', 'devicon-mysql-plain', '#4479A1', '/assets/technologies/icons8-mysql-48.png'],//
            ['PostgreSQL', 'databases', 'proficient', 'devicon-postgresql-plain', '#4169E1', '/assets/technologies/icons8-postgresql-48.png'],//
            ['MongoDB', 'databases', 'proficient', 'devicon-mongodb-plain', '#47A248', '/assets/technologies/icons8-mongodb-48.png'],//
            ['Redis', 'databases', 'proficient', 'devicon-redis-plain', '#DC382D', '/assets/technologies/icons8-redis-48.png'],//
            // Big data
            ['Hadoop', 'big-data', 'familiar', 'devicon-hadoop-plain', '#66CCFF', '/assets/technologies/icons8-hadoop-distributed-file-system-48.png'],//
            ['Spark', 'big-data', 'familiar', 'devicon-apachespark-plain', '#E25A1C', '/assets/technologies/icons8-apache-spark-48.png'],//
            // DevOps & cloud
            ['Jira', 'devops-cloud', 'proficient', 'devicon-jira-plain', '#0052CC', '/assets/technologies/icons8-jira-48.png'],//
            ['Trello', 'devops-cloud', 'proficient', 'devicon-trello-plain', '#0052CC', '/assets/technologies/icons8-trello-48.png'],//
            ['Git', 'devops-cloud', 'core', 'devicon-git-plain', '#F05032', '/assets/technologies/icons8-git-48.png'],//
            ['Jenkins', 'devops-cloud', 'proficient', 'devicon-jenkins-plain', '#D24939', '/assets/technologies/icons8-jenkins-48.png'],//
            ['GitHub Actions', 'devops-cloud', 'proficient', 'devicon-githubactions-plain', '#2088FF', '/assets/technologies/icons8-github-48.png'],//
            ['GitLab CI', 'devops-cloud', 'proficient', 'devicon-gitlab-plain', '#FC6D26', '/assets/technologies/icons8-gitlab-48.png'],//
            ['Docker', 'devops-cloud', 'core', 'devicon-docker-plain', '#2496ED', '/assets/technologies/icons8-docker-48.png'],//
            ['AWS EC2', 'devops-cloud', 'core', 'devicon-amazonwebservices-plain-wordmark', '#FF9900', '/assets/technologies/icons8-amazon-web-services-48.png'],//
            ['Kubernetes', 'devops-cloud', 'familiar', 'devicon-kubernetes-plain', '#326CE5', '/assets/technologies/icons8-kubernetes-48.png'],//
            ['Grafana', 'devops-cloud', 'proficient', 'devicon-grafana-original', '#F46800', '/assets/technologies/icons8-grafana-48.png'],//
            ['Prometheus', 'devops-cloud', 'proficient', 'devicon-prometheus-original', '#E6522C', '/assets/technologies/icons8-prometheus-48.png'],//
            // AI / data science
            ['Deep Learning', 'ai-data-science', 'familiar', null, null, '/assets/technologies/icons8-deep-learning-64.png'],
            ['NLP', 'ai-data-science', 'familiar', null, null, '/assets/technologies/icons8-brain-94.png'],
            ['Data Analytics', 'ai-data-science', 'proficient', null, null, '/assets/technologies/icons8-data-analytics-64.png'],
            ['MLOps', 'ai-data-science', 'familiar', null, null, '/assets/technologies/mlops.png'],
        ];
        // A curated handful shown on the home-page tech strip.
        $dev = ['Laravel', 'Vue.js', 'TypeScript', 'Python', 'MySQL'];
        $devops = ['Docker', 'AWS EC2', 'Jenkins',];
        $ai = ['Spark', 'NLP'];
        $featured = array_merge($ai, $devops, $dev);
        $order = 0;
        foreach ($techs as [$name, $group, $prof, $icon, $color, $icon_url]) {
            DB::table('technologies')->updateOrInsert(
                ['name' => $name],
                [
                    'group_id' => $gid($group),
                    'proficiency' => $prof,
                    'icon_class' => $icon,
                    'icon_url' => $icon_url,
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

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
                'photo_url' => '/assets/author/author.png',
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

        // ── Categories ─────────────────────────────────────────────────────
        $categories = [
            ['tutorials', 'Tutorials', 'Tutoriels', 'دروس', 1],
            ['web-dev', 'Web Development', 'Développement Web', 'تطوير الويب', 2],
            ['devops', 'DevOps', 'DevOps', 'DevOps', 3],
            ['ai-ml', 'AI & ML', 'IA & ML', 'الذكاء الاصطناعي', 4],
            ['career', 'Career', 'Carrière', 'مسيرة مهنية', 5],
        ];
        foreach ($categories as [$slug, $en, $fr, $ar, $order]) {
            DB::table('blog_categories')->updateOrInsert(
                ['slug' => $slug],
                ['name_en' => $en, 'name_fr' => $fr, 'name_ar' => $ar, 'sort_order' => $order, 'is_active' => true, 'updated_at' => $now, 'created_at' => $now]
            );
        }
        $catId = fn (string $slug) => DB::table('blog_categories')->where('slug', $slug)->value('id');

        // ── Posts ────────────────────────────────────────────────────────────
        // Sourced from Oussema_Blog_Ideas.xlsx — each idea expanded into a
        // three-section trilingual article with a matching table of contents.
        $posts = [
            [
                'slug' => 'shrink-dockerfile-multi-stage-builds',
                'is_featured' => true,
                'read_time' => 5,
                'published_at' => '2026-07-15 09:00:00',
                'cover' => '/assets/blogs/blog1.png',
                'title_en' => 'I Deleted 60% of My Dockerfile and My App Got Faster',
                'title_fr' => 'J\'ai supprimé 60 % de mon Dockerfile et mon app est devenue plus rapide',
                'title_ar' => 'حذفت 60٪ من ملف Dockerfile فصار تطبيقي أسرع',
                'excerpt_en' => 'Why your container images are probably bloated — and the multi-stage fix.',
                'excerpt_fr' => 'Pourquoi vos images de conteneurs sont probablement trop lourdes — et la solution multi-stage.',
                'excerpt_ar' => 'لماذا تكون صور الحاويات لديك أثقل مما يجب على الأرجح — والحل عبر البناء متعدّد المراحل.',
                'body_en' => '<h2 id="bloat">Why images get bloated</h2><p>Most developers ship images three to five times bigger than they need to. The usual culprit is a single-stage Dockerfile that drags build tools, dev dependencies and layers of cache straight into production. Every one of those megabytes slows pulls and cold starts and widens your attack surface.</p><h2 id="multi-stage">The multi-stage fix</h2><p>Multi-stage builds split the work: compile in one stage, then copy only the finished artifact into a slim runtime stage such as <code>alpine</code> or <code>distroless</code>. The build tools never make it into the final image, so it stays small and fast to ship.</p><h2 id="start">Where to start</h2><p>Rule of thumb: if your Node or Python image is over 300MB, you have room to cut. Run <code>docker history &lt;image&gt;</code> to see which layers eat the most space — once you look, the offenders are usually obvious.</p>',
                'body_fr' => '<h2 id="bloat">Pourquoi les images gonflent</h2><p>La plupart des développeurs livrent des images trois à cinq fois plus grosses que nécessaire. Le coupable habituel est un Dockerfile mono-stage qui entraîne les outils de build, les dépendances de développement et des couches de cache directement en production. Chacun de ces mégaoctets ralentit les téléchargements et les démarrages à froid, et élargit la surface d\'attaque.</p><h2 id="multi-stage">La solution multi-stage</h2><p>Les builds multi-stage séparent le travail : on compile dans une étape, puis on copie uniquement l\'artefact final dans une étape d\'exécution légère comme <code>alpine</code> ou <code>distroless</code>. Les outils de build n\'atteignent jamais l\'image finale, qui reste petite et rapide à livrer.</p><h2 id="start">Par où commencer</h2><p>Règle générale : si votre image Node ou Python dépasse 300 Mo, il y a de la marge. Lancez <code>docker history &lt;image&gt;</code> pour voir quelles couches consomment le plus d\'espace — une fois que vous regardez, les responsables sautent aux yeux.</p>',
                'body_ar' => '<h2 id="bloat">لماذا تتضخّم الصور</h2><p>يشحن معظم المطوّرين صورًا أكبر مما تحتاج بثلاث إلى خمس مرات. السبب المعتاد هو Dockerfile بمرحلة واحدة يجرّ أدوات البناء وتبعيات التطوير وطبقات الذاكرة المؤقتة مباشرةً إلى الإنتاج. كل ميغابايت من ذلك يبطّئ التنزيل والإقلاع البارد ويوسّع سطح الهجوم.</p><h2 id="multi-stage">الحل متعدّد المراحل</h2><p>يقسّم البناء متعدّد المراحل العمل: تُجمّع في مرحلة، ثم تنسخ الناتج النهائي فقط إلى مرحلة تشغيل خفيفة مثل <code>alpine</code> أو <code>distroless</code>. لا تصل أدوات البناء أبدًا إلى الصورة النهائية، فتبقى صغيرة وسريعة الشحن.</p><h2 id="start">من أين تبدأ</h2><p>قاعدة عامة: إذا تجاوزت صورة Node أو Python لديك 300 ميغابايت، فأمامك مجال للتقليص. شغّل <code>docker history &lt;image&gt;</code> لترى أي الطبقات تلتهم المساحة — بمجرد أن تنظر، يتّضح المذنبون عادةً.</p>',
                'categories' => ['devops', 'tutorials'],
                'toc' => [
                    ['bloat', 'Why images get bloated', 'Pourquoi les images gonflent', 'لماذا تتضخّم الصور'],
                    ['multi-stage', 'The multi-stage fix', 'La solution multi-stage', 'الحل متعدّد المراحل'],
                    ['start', 'Where to start', 'Par où commencer', 'من أين تبدأ'],
                ],
                'related' => ['kubernetes-is-overkill-until-its-not', 'infrastructure-as-code-cattle-not-pets'],
            ],
            [
                'slug' => 'cicd-in-plain-english',
                'is_featured' => false,
                'read_time' => 4,
                'published_at' => '2026-06-24 10:30:00',
                'cover' => '/assets/blogs/blog2.png',
                'title_en' => 'CI/CD in Plain English (No Buzzwords)',
                'title_fr' => 'Le CI/CD en langage clair (sans jargon)',
                'title_ar' => 'CI/CD بلغة بسيطة (بلا مصطلحات رنّانة)',
                'excerpt_en' => 'The pipeline explained the way I wish someone had explained it to me.',
                'excerpt_fr' => 'Le pipeline expliqué comme j\'aurais aimé qu\'on me l\'explique.',
                'excerpt_ar' => 'شرح خطّ الإنتاج بالطريقة التي تمنّيت لو شرحها لي أحدهم.',
                'body_en' => '<h2 id="ci">Continuous Integration</h2><p>CI/CD sounds intimidating until you realise it is just "a robot that checks and ships your code so you don\'t have to." Continuous Integration is the first half: every time you push, an automated job builds your code and runs the tests. If something breaks, you find out in minutes instead of days.</p><h2 id="cd">Continuous Delivery</h2><p>Continuous Delivery (or Deployment) is the second half: if the tests pass, the same robot packages the app and pushes it toward production automatically. That is the whole idea — no ceremony, no 2am manual deploys.</p><h2 id="discipline">It\'s discipline, not tools</h2><p>The magic isn\'t Jenkins, GitHub Actions or GitLab CI — it\'s the discipline behind them: small commits, fast tests and trusting the pipeline. Start with a single job that runs your tests on every push, then add stages later.</p>',
                'body_fr' => '<h2 id="ci">L\'intégration continue</h2><p>Le CI/CD paraît intimidant jusqu\'à ce qu\'on comprenne que c\'est simplement « un robot qui vérifie et livre votre code à votre place ». L\'intégration continue en est la première moitié : à chaque push, un job automatisé compile votre code et lance les tests. Si quelque chose casse, vous le savez en quelques minutes, pas en quelques jours.</p><h2 id="cd">La livraison continue</h2><p>La livraison (ou le déploiement) continue en est la seconde moitié : si les tests passent, le même robot empaquette l\'application et la pousse automatiquement vers la production. C\'est toute l\'idée — sans cérémonie, sans déploiement manuel à 2h du matin.</p><h2 id="discipline">C\'est une discipline, pas des outils</h2><p>La magie n\'est pas Jenkins, GitHub Actions ou GitLab CI — c\'est la discipline qui les sous-tend : petits commits, tests rapides et confiance dans le pipeline. Commencez par un seul job qui lance vos tests à chaque push, puis ajoutez des étapes plus tard.</p>',
                'body_ar' => '<h2 id="ci">التكامل المستمر</h2><p>يبدو CI/CD مخيفًا حتى تدرك أنه مجرّد «روبوت يفحص كودك ويشحنه بدلًا منك». التكامل المستمر هو النصف الأول: في كل مرة تدفع فيها الكود، تبني مهمّة آلية شيفرتك وتشغّل الاختبارات. وإن انكسر شيء، تعرف ذلك خلال دقائق لا أيام.</p><h2 id="cd">التسليم المستمر</h2><p>التسليم (أو النشر) المستمر هو النصف الثاني: إذا نجحت الاختبارات، يحزم الروبوت نفسه التطبيق ويدفعه نحو الإنتاج تلقائيًا. هذه هي الفكرة كلها — بلا طقوس وبلا نشر يدوي في الثانية صباحًا.</p><h2 id="discipline">إنها انضباط لا أدوات</h2><p>السحر ليس في Jenkins أو GitHub Actions أو GitLab CI — بل في الانضباط خلفها: التزامات صغيرة، واختبارات سريعة، وثقة في خطّ الإنتاج. ابدأ بمهمّة واحدة تشغّل اختباراتك عند كل دفع، ثم أضف المراحل لاحقًا.</p>',
                'categories' => ['devops'],
                'toc' => [
                    ['ci', 'Continuous Integration', 'L\'intégration continue', 'التكامل المستمر'],
                    ['cd', 'Continuous Delivery', 'La livraison continue', 'التسليم المستمر'],
                    ['discipline', 'It\'s discipline, not tools', 'C\'est une discipline, pas des outils', 'إنها انضباط لا أدوات'],
                ],
                'related' => ['git-habits-juniors-vs-seniors', 'stop-writing-bash-scripts-like-2005'],
            ],
            [
                'slug' => 'why-your-aws-bill-is-high',
                'is_featured' => false,
                'read_time' => 5,
                'published_at' => '2026-06-05 09:15:00',
                'cover' => '/assets/blogs/blog3.png',
                'title_en' => 'Your AWS Bill Is High Because of These 3 Things',
                'title_fr' => 'Votre facture AWS est élevée à cause de ces 3 choses',
                'title_ar' => 'فاتورة AWS لديك مرتفعة بسبب هذه الأمور الثلاثة',
                'excerpt_en' => 'The silent budget killers hiding in your cloud account.',
                'excerpt_fr' => 'Les tueurs de budget silencieux cachés dans votre compte cloud.',
                'excerpt_ar' => 'قتلة الميزانية الصامتون المختبئون في حساب السحابة لديك.',
                'body_en' => '<h2 id="idle">Idle instances</h2><p>Cloud bills balloon quietly, and it\'s almost always the same three offenders. The first is idle EC2 instances left running 24/7 for workloads that only need business hours. Schedule them off outside working hours or put them behind auto-scaling.</p><h2 id="storage">Forgotten storage</h2><p>The second is unattached EBS volumes and old snapshots you forgot to delete after terminating instances. They sit there costing money while doing absolutely nothing.</p><h2 id="transfer">Invisible data transfer</h2><p>The third is data transfer — especially cross-region traffic and NAT gateway costs, which stay invisible until the invoice lands. Turn on Cost Explorer, set a billing alarm today, and tag everything so you can see who owns what. Ten minutes of cleanup often trims a bill by 20 to 30 percent.</p>',
                'body_fr' => '<h2 id="idle">Les instances inactives</h2><p>Les factures cloud gonflent en silence, et ce sont presque toujours les trois mêmes coupables. Le premier : des instances EC2 inactives laissées allumées 24h/24 pour des charges qui n\'ont besoin que des heures de bureau. Éteignez-les en dehors des heures ouvrées ou placez-les derrière de l\'auto-scaling.</p><h2 id="storage">Le stockage oublié</h2><p>Le deuxième : des volumes EBS détachés et de vieux snapshots que vous avez oublié de supprimer après avoir terminé des instances. Ils restent là à coûter de l\'argent sans rien faire.</p><h2 id="transfer">Le transfert de données invisible</h2><p>Le troisième : le transfert de données — surtout le trafic inter-régions et les coûts de passerelle NAT, invisibles jusqu\'à l\'arrivée de la facture. Activez Cost Explorer, définissez une alarme de facturation dès aujourd\'hui et taguez tout pour savoir qui possède quoi. Dix minutes de nettoyage réduisent souvent une facture de 20 à 30 %.</p>',
                'body_ar' => '<h2 id="idle">النسخ الخاملة</h2><p>تتضخّم فواتير السحابة بصمت، والسبب دائمًا تقريبًا هو المذنبون الثلاثة أنفسهم. الأول: نسخ EC2 خاملة تُترك تعمل على مدار الساعة لأحمال لا تحتاج سوى ساعات الدوام. أطفئها خارج أوقات العمل أو ضعها خلف التوسّع التلقائي.</p><h2 id="storage">التخزين المنسيّ</h2><p>الثاني: أقراص EBS غير المرتبطة واللقطات القديمة التي نسيت حذفها بعد إنهاء النسخ. تبقى هناك تكلّفك المال دون أن تفعل شيئًا على الإطلاق.</p><h2 id="transfer">نقل البيانات الخفيّ</h2><p>الثالث: نقل البيانات — خاصةً حركة المرور بين المناطق وتكاليف بوابة NAT، وهي خفيّة حتى تصل الفاتورة. فعّل Cost Explorer، واضبط تنبيه فوترة اليوم، ووسم كل شيء لتعرف من يملك ماذا. غالبًا ما تقلّص عشر دقائق من التنظيف الفاتورة بنسبة 20 إلى 30 بالمئة.</p>',
                'categories' => ['devops'],
                'toc' => [
                    ['idle', 'Idle instances', 'Les instances inactives', 'النسخ الخاملة'],
                    ['storage', 'Forgotten storage', 'Le stockage oublié', 'التخزين المنسيّ'],
                    ['transfer', 'Invisible data transfer', 'Le transfert de données invisible', 'نقل البيانات الخفيّ'],
                ],
                'related' => ['infrastructure-as-code-cattle-not-pets', 'kubernetes-is-overkill-until-its-not'],
            ],
            [
                'slug' => 'kubernetes-is-overkill-until-its-not',
                'is_featured' => true,
                'read_time' => 6,
                'published_at' => '2026-05-20 14:00:00',
                'cover' => '/assets/blogs/blog4.png',
                'title_en' => 'Kubernetes Is Overkill (Until It Isn\'t)',
                'title_fr' => 'Kubernetes est excessif (jusqu\'à ce qu\'il ne le soit plus)',
                'title_ar' => 'كوبرنيتيس مبالغة (إلى أن يصبح ضرورة)',
                'excerpt_en' => 'An honest take on when you actually need it — and when Docker Compose wins.',
                'excerpt_fr' => 'Un avis honnête sur le moment où vous en avez vraiment besoin — et celui où Docker Compose gagne.',
                'excerpt_ar' => 'رأي صادق عن الوقت الذي تحتاجه فيه فعلًا — والوقت الذي يفوز فيه Docker Compose.',
                'body_en' => '<h2 id="default">The default answer</h2><p>Kubernetes is the reflex answer in every architecture discussion, but for many teams it solves problems they don\'t have yet. If you\'re running a handful of containers on a single project, Docker Compose or a managed service will take you further with a fraction of the complexity.</p><h2 id="earns">When it earns its weight</h2><p>Kubernetes pays off when you genuinely need self-healing, horizontal auto-scaling across many nodes, rolling zero-downtime deploys and multi-team workload isolation. Until those needs are real, most of the platform is weight you carry for nothing.</p><h2 id="cost">The real cost</h2><p>The real cost of K8s isn\'t the cluster — it\'s the ongoing operational knowledge your whole team now has to carry. Adopt it when the pain of not having it is bigger than the pain of running it, and not a day before.</p>',
                'body_fr' => '<h2 id="default">La réponse par défaut</h2><p>Kubernetes est la réponse réflexe dans chaque discussion d\'architecture, mais pour beaucoup d\'équipes il résout des problèmes qu\'elles n\'ont pas encore. Si vous faites tourner une poignée de conteneurs sur un seul projet, Docker Compose ou un service managé vous mènera plus loin avec une fraction de la complexité.</p><h2 id="earns">Quand il justifie son poids</h2><p>Kubernetes devient rentable lorsque vous avez réellement besoin d\'auto-réparation, d\'auto-scaling horizontal sur de nombreux nœuds, de déploiements progressifs sans interruption et d\'isolation des charges entre plusieurs équipes. Tant que ces besoins ne sont pas réels, l\'essentiel de la plateforme n\'est qu\'un poids porté pour rien.</p><h2 id="cost">Le vrai coût</h2><p>Le vrai coût de K8s n\'est pas le cluster — c\'est le savoir opérationnel permanent que toute votre équipe doit désormais porter. Adoptez-le quand la douleur de ne pas l\'avoir dépasse celle de le faire tourner, pas un jour avant.</p>',
                'body_ar' => '<h2 id="default">الجواب الافتراضي</h2><p>كوبرنيتيس هو الجواب التلقائي في كل نقاش معماري، لكنه لدى كثير من الفرق يحلّ مشكلات لا يملكونها بعد. إن كنت تشغّل حفنة من الحاويات في مشروع واحد، فإن Docker Compose أو خدمة مُدارة ستأخذك أبعد بجزء بسيط من التعقيد.</p><h2 id="earns">متى يستحقّ ثِقله</h2><p>يصبح كوبرنيتيس مُجديًا حين تحتاج فعلًا إلى التعافي الذاتي، والتوسّع الأفقي عبر عقد كثيرة، والنشر التدريجي دون توقّف، وعزل الأحمال بين عدة فرق. وما لم تكن هذه الحاجات حقيقية، فمعظم المنصّة ثِقل تحمله بلا مقابل.</p><h2 id="cost">التكلفة الحقيقية</h2><p>التكلفة الحقيقية لكوبرنيتيس ليست العنقود — بل المعرفة التشغيلية المستمرة التي صار على فريقك كله أن يحملها. تبنَّه حين يصبح ألم غيابه أكبر من ألم تشغيله، ولا يومًا قبل ذلك.</p>',
                'categories' => ['devops'],
                'toc' => [
                    ['default', 'The default answer', 'La réponse par défaut', 'الجواب الافتراضي'],
                    ['earns', 'When it earns its weight', 'Quand il justifie son poids', 'متى يستحقّ ثِقله'],
                    ['cost', 'The real cost', 'Le vrai coût', 'التكلفة الحقيقية'],
                ],
                'related' => ['shrink-dockerfile-multi-stage-builds', 'why-your-microservices-feel-slower'],
            ],
            [
                'slug' => 'rag-explained-without-the-hype',
                'is_featured' => true,
                'read_time' => 6,
                'published_at' => '2026-05-02 11:00:00',
                'cover' => '/assets/blogs/blog5.png',
                'title_en' => 'RAG Explained Without the Hype',
                'title_fr' => 'Le RAG expliqué sans le battage',
                'title_ar' => 'شرح RAG بلا مبالغات',
                'excerpt_en' => 'How to make an LLM answer questions about YOUR data.',
                'excerpt_fr' => 'Comment faire répondre un LLM à des questions sur VOS données.',
                'excerpt_ar' => 'كيف تجعل نموذجًا لغويًا يجيب عن أسئلة تخصّ بياناتك أنت.',
                'body_en' => '<h2 id="problem">What RAG solves</h2><p>Large language models are smart, but they don\'t know your company\'s docs, your product, or anything after their training cutoff. Retrieval-Augmented Generation fixes that without expensive retraining.</p><h2 id="how">How it works</h2><p>The idea is simple: when a user asks a question, you first search your own documents for the relevant chunks, then hand those chunks to the model along with the question. Under the hood you chunk your documents, turn them into embeddings, store them in a vector database, and retrieve the closest matches at query time. The model answers using that fresh context.</p><h2 id="why">Why it beats fine-tuning</h2><p>RAG is why a chatbot can suddenly "know" your internal wiki. It\'s cheaper, faster to update and easier to trust than fine-tuning for most use cases — change a document and the next answer already reflects it.</p>',
                'body_fr' => '<h2 id="problem">Ce que le RAG résout</h2><p>Les grands modèles de langage sont intelligents, mais ils ne connaissent pas la documentation de votre entreprise, votre produit, ni quoi que ce soit après leur date de coupure d\'entraînement. La génération augmentée par récupération (RAG) corrige cela sans réentraînement coûteux.</p><h2 id="how">Comment ça marche</h2><p>L\'idée est simple : quand un utilisateur pose une question, vous cherchez d\'abord dans vos propres documents les passages pertinents, puis vous les transmettez au modèle avec la question. En coulisses, vous découpez vos documents, les transformez en embeddings, les stockez dans une base vectorielle et récupérez les correspondances les plus proches au moment de la requête. Le modèle répond à partir de ce contexte frais.</p><h2 id="why">Pourquoi c\'est mieux que le fine-tuning</h2><p>Le RAG explique pourquoi un chatbot peut soudain « connaître » votre wiki interne. Pour la plupart des cas d\'usage, il est moins cher, plus rapide à mettre à jour et plus digne de confiance que le fine-tuning — modifiez un document et la réponse suivante en tient déjà compte.</p>',
                'body_ar' => '<h2 id="problem">ما الذي يحلّه RAG</h2><p>النماذج اللغوية الكبيرة ذكية، لكنها لا تعرف وثائق شركتك ولا منتجك ولا أي شيء بعد تاريخ انتهاء تدريبها. تعالج التوليد المعزّز بالاسترجاع (RAG) ذلك دون إعادة تدريب مكلفة.</p><h2 id="how">كيف يعمل</h2><p>الفكرة بسيطة: عندما يطرح المستخدم سؤالًا، تبحث أولًا في وثائقك عن المقاطع ذات الصلة، ثم تسلّمها للنموذج مع السؤال. خلف الكواليس تقسّم وثائقك إلى مقاطع، وتحوّلها إلى تضمينات (embeddings)، وتخزّنها في قاعدة بيانات متّجهة، وتسترجع أقرب التطابقات وقت الاستعلام. ويجيب النموذج اعتمادًا على هذا السياق الطازج.</p><h2 id="why">لماذا يتفوّق على الضبط الدقيق</h2><p>RAG هو سبب قدرة روبوت المحادثة فجأةً على «معرفة» ويكي فريقك الداخلي. في معظم الحالات هو أرخص وأسرع تحديثًا وأجدر بالثقة من الضبط الدقيق (fine-tuning) — غيّر وثيقةً فتنعكس في الإجابة التالية فورًا.</p>',
                'categories' => ['ai-ml', 'tutorials'],
                'toc' => [
                    ['problem', 'What RAG solves', 'Ce que le RAG résout', 'ما الذي يحلّه RAG'],
                    ['how', 'How it works', 'Comment ça marche', 'كيف يعمل'],
                    ['why', 'Why it beats fine-tuning', 'Pourquoi c\'est mieux que le fine-tuning', 'لماذا يتفوّق على الضبط الدقيق'],
                ],
                'related' => ['the-mlops-gap-nobody-warns-you-about', 'cicd-in-plain-english'],
            ],
            [
                'slug' => 'the-mlops-gap-nobody-warns-you-about',
                'is_featured' => false,
                'read_time' => 5,
                'published_at' => '2026-04-15 09:45:00',
                'cover' => '/assets/blogs/blog6.png',
                'title_en' => 'The MLOps Gap Nobody Warns You About',
                'title_fr' => 'Le fossé MLOps dont personne ne vous parle',
                'title_ar' => 'فجوة MLOps التي لا يحذّرك منها أحد',
                'excerpt_en' => 'Your model works in the notebook. Now the real work begins.',
                'excerpt_fr' => 'Votre modèle marche dans le notebook. Le vrai travail commence maintenant.',
                'excerpt_ar' => 'نموذجك يعمل في الـnotebook. الآن يبدأ العمل الحقيقي.',
                'body_en' => '<h2 id="notebook">The notebook is 10%</h2><p>A model that hits 95% accuracy in a Jupyter notebook is maybe 10% of the job. The other 90% — the part nobody teaches — is getting that model to run reliably in production and stay useful over time.</p><h2 id="what">What MLOps actually is</h2><p>You need versioning for data and models, not just code. You need monitoring for drift, because the world changes and your model silently gets worse. You need reproducible pipelines so retraining isn\'t a manual ritual. And you need a rollback plan for when a new model performs worse than the old one.</p><h2 id="skills">A different skill set</h2><p>The skills that make you a great data scientist and the skills that keep a model alive in production are almost entirely different. Learning that second set is what makes you genuinely dangerous.</p>',
                'body_fr' => '<h2 id="notebook">Le notebook, c\'est 10 %</h2><p>Un modèle qui atteint 95 % de précision dans un notebook Jupyter, c\'est peut-être 10 % du travail. Les 90 % restants — la partie que personne n\'enseigne — consistent à faire tourner ce modèle de façon fiable en production et à le garder utile dans le temps.</p><h2 id="what">Ce qu\'est vraiment le MLOps</h2><p>Il vous faut du versioning pour les données et les modèles, pas seulement pour le code. Il vous faut une surveillance de la dérive, car le monde change et votre modèle se dégrade en silence. Il vous faut des pipelines reproductibles pour que le réentraînement ne soit pas un rituel manuel. Et il vous faut un plan de rollback pour quand un nouveau modèle fait pire que l\'ancien.</p><h2 id="skills">Un autre jeu de compétences</h2><p>Les compétences qui font de vous un excellent data scientist et celles qui maintiennent un modèle en vie en production sont presque entièrement différentes. Apprendre le second jeu, c\'est ce qui vous rend réellement redoutable.</p>',
                'body_ar' => '<h2 id="notebook">الـnotebook هو 10٪ فقط</h2><p>نموذج يحقّق دقة 95٪ في notebook من Jupyter هو ربما 10٪ من العمل. أما الـ90٪ الباقية — الجزء الذي لا يعلّمه أحد — فهي جعل ذلك النموذج يعمل بموثوقية في الإنتاج ويبقى مفيدًا مع الوقت.</p><h2 id="what">ما هو MLOps حقًّا</h2><p>تحتاج إلى إصدارات للبيانات والنماذج، لا للكود وحده. وتحتاج إلى مراقبة الانحراف، لأن العالم يتغيّر ونموذجك يسوء بصمت. وتحتاج إلى خطوط أنابيب قابلة لإعادة الإنتاج كي لا تكون إعادة التدريب طقسًا يدويًا. وتحتاج إلى خطة تراجع حين يؤدّي نموذج جديد أسوأ من القديم.</p><h2 id="skills">مجموعة مهارات مختلفة</h2><p>المهارات التي تجعلك عالِم بيانات بارعًا والمهارات التي تُبقي نموذجًا حيًّا في الإنتاج مختلفة تمامًا تقريبًا. تعلّم المجموعة الثانية هو ما يجعلك خطيرًا فعلًا.</p>',
                'categories' => ['ai-ml', 'devops'],
                'toc' => [
                    ['notebook', 'The notebook is 10%', 'Le notebook, c\'est 10 %', 'الـnotebook هو 10٪ فقط'],
                    ['what', 'What MLOps actually is', 'Ce qu\'est vraiment le MLOps', 'ما هو MLOps حقًّا'],
                    ['skills', 'A different skill set', 'Un autre jeu de compétences', 'مجموعة مهارات مختلفة'],
                ],
                'related' => ['rag-explained-without-the-hype', 'infrastructure-as-code-cattle-not-pets'],
            ],
            [
                'slug' => 'stop-writing-bash-scripts-like-2005',
                'is_featured' => false,
                'read_time' => 5,
                'published_at' => '2026-03-28 16:20:00',
                'cover' => '/assets/blogs/blog7.png',
                'title_en' => 'Stop Writing Bash Scripts Like It\'s 2005',
                'title_fr' => 'Arrêtez d\'écrire vos scripts Bash comme en 2005',
                'title_ar' => 'توقّف عن كتابة سكربتات Bash كأننا في 2005',
                'excerpt_en' => 'Small habits that make your automation actually maintainable.',
                'excerpt_fr' => 'De petites habitudes qui rendent votre automatisation vraiment maintenable.',
                'excerpt_ar' => 'عادات صغيرة تجعل أتمتتك قابلة للصيانة فعلًا.',
                'body_en' => '<h2 id="fragile">Why scripts rot</h2><p>Bash scripts have a way of turning into fragile 200-line monsters that only their author understands. A few small habits change everything.</p><h2 id="habits">Habits that help</h2><p>Start every script with <code>set -euo pipefail</code> so it fails loudly instead of silently corrupting things. Quote your variables (<code>"$var"</code>) to survive spaces and empty values. Use functions instead of copy-pasting blocks. And add a <code>usage()</code> message so future-you knows how to run it.</p><h2 id="line">Know when to switch</h2><p>The moment a script needs real data structures or serious error handling, that\'s your signal to switch to Python. Bash is a fantastic glue language and a terrible application language — knowing where that line sits saves you countless hours.</p>',
                'body_fr' => '<h2 id="fragile">Pourquoi les scripts pourrissent</h2><p>Les scripts Bash ont tendance à se transformer en monstres fragiles de 200 lignes que seul leur auteur comprend. Quelques petites habitudes changent tout.</p><h2 id="habits">Des habitudes qui aident</h2><p>Commencez chaque script par <code>set -euo pipefail</code> pour qu\'il échoue bruyamment au lieu de corrompre les choses en silence. Mettez vos variables entre guillemets (<code>"$var"</code>) pour survivre aux espaces et aux valeurs vides. Utilisez des fonctions au lieu de copier-coller des blocs. Et ajoutez un message <code>usage()</code> pour que le futur vous sache comment le lancer.</p><h2 id="line">Savoir quand changer</h2><p>Dès qu\'un script a besoin de vraies structures de données ou d\'une gestion d\'erreurs sérieuse, c\'est le signal de passer à Python. Bash est un formidable langage de colle et un piètre langage d\'application — savoir où se situe cette limite vous épargne d\'innombrables heures.</p>',
                'body_ar' => '<h2 id="fragile">لماذا تتعفّن السكربتات</h2><p>لسكربتات Bash نزعة للتحوّل إلى وحوش هشّة من 200 سطر لا يفهمها سوى كاتبها. بضع عادات صغيرة تغيّر كل شيء.</p><h2 id="habits">عادات تساعد</h2><p>ابدأ كل سكربت بـ<code>set -euo pipefail</code> ليفشل بصوت عالٍ بدل أن يفسد الأمور بصمت. ضع متغيّراتك بين علامتَي اقتباس (<code>"$var"</code>) لتصمد أمام المسافات والقيم الفارغة. استخدم الدوال بدل نسخ الكتل ولصقها. وأضف رسالة <code>usage()</code> كي يعرف أنتَ في المستقبل كيف تشغّله.</p><h2 id="line">اعرف متى تنتقل</h2><p>لحظة أن يحتاج سكربت إلى بِنى بيانات حقيقية أو معالجة أخطاء جادّة، فتلك إشارتك للانتقال إلى Python. Bash لغة لصق رائعة ولغة تطبيقات سيّئة — ومعرفة موضع هذا الخط توفّر عليك ساعات لا تُحصى.</p>',
                'categories' => ['devops', 'tutorials'],
                'toc' => [
                    ['fragile', 'Why scripts rot', 'Pourquoi les scripts pourrissent', 'لماذا تتعفّن السكربتات'],
                    ['habits', 'Habits that help', 'Des habitudes qui aident', 'عادات تساعد'],
                    ['line', 'Know when to switch', 'Savoir quand changer', 'اعرف متى تنتقل'],
                ],
                'related' => ['cicd-in-plain-english', 'git-habits-juniors-vs-seniors'],
            ],
            [
                'slug' => 'infrastructure-as-code-cattle-not-pets',
                'is_featured' => false,
                'read_time' => 6,
                'published_at' => '2026-03-11 08:30:00',
                'cover' => '/assets/blogs/blog8.png',
                'title_en' => 'Infrastructure as Code Changed How I Think About Servers',
                'title_fr' => 'L\'Infrastructure as Code a changé ma vision des serveurs',
                'title_ar' => 'البنية التحتية ككود غيّرت نظرتي إلى الخوادم',
                'excerpt_en' => 'Why "cattle, not pets" is the mindset shift that matters.',
                'excerpt_fr' => 'Pourquoi « du bétail, pas des animaux de compagnie » est le vrai changement de mentalité.',
                'excerpt_ar' => 'لماذا «ماشية لا حيوانات أليفة» هو التحوّل الذهني الذي يهمّ.',
                'body_en' => '<h2 id="pets">Servers as pets</h2><p>For years I treated servers like pets: I named them, logged in, hand-tuned their config, and panicked when one got sick. Every server was a precious, hand-raised creature — and every outage was a mystery only I could untangle.</p><h2 id="cattle">Servers as cattle</h2><p>Infrastructure as Code flipped that. With tools like Terraform, your entire environment lives in version-controlled files. A server becomes cattle: disposable, identical, described in code and recreated on demand. Changes go through code review, and you can spin up a perfect copy of production for testing in minutes.</p><h2 id="shift">The mindset shift</h2><p>The mindset shift is the hard part — but once it clicks, no more "it works on that one server" mysteries. Manually SSH-ing in to fix things starts to feel like a bug, not a workflow.</p>',
                'body_fr' => '<h2 id="pets">Les serveurs comme animaux de compagnie</h2><p>Pendant des années, j\'ai traité les serveurs comme des animaux de compagnie : je les nommais, je m\'y connectais, je réglais leur configuration à la main et je paniquais quand l\'un tombait malade. Chaque serveur était une créature précieuse, élevée à la main — et chaque panne un mystère que moi seul pouvais démêler.</p><h2 id="cattle">Les serveurs comme du bétail</h2><p>L\'Infrastructure as Code a renversé cela. Avec des outils comme Terraform, tout votre environnement vit dans des fichiers versionnés. Un serveur devient du bétail : jetable, identique, décrit en code et recréé à la demande. Les changements passent par la revue de code, et vous pouvez monter une copie parfaite de la production pour les tests en quelques minutes.</p><h2 id="shift">Le changement de mentalité</h2><p>Le changement de mentalité est la partie difficile — mais une fois qu\'il s\'opère, fini les mystères du type « ça marche sur ce serveur-là ». Se connecter en SSH à la main pour réparer commence à ressembler à un bug, pas à un flux de travail.</p>',
                'body_ar' => '<h2 id="pets">الخوادم كحيوانات أليفة</h2><p>لسنوات عاملت الخوادم كحيوانات أليفة: أسمّيها، وأسجّل الدخول إليها، وأضبط إعداداتها يدويًا، وأصاب بالذعر حين يمرض أحدها. كان كل خادم كائنًا ثمينًا ربّيته بيديّ — وكل انقطاع لغزًا لا يحلّه سواي.</p><h2 id="cattle">الخوادم كماشية</h2><p>قلبت البنية التحتية ككود ذلك. مع أدوات مثل Terraform، تعيش بيئتك كاملةً في ملفات خاضعة للتحكّم بالإصدارات. يصير الخادم ماشيةً: قابلًا للاستبدال، ومتطابقًا، وموصوفًا بالكود، ويُعاد إنشاؤه عند الطلب. تمرّ التغييرات عبر مراجعة الكود، ويمكنك بناء نسخة مطابقة للإنتاج للاختبار في دقائق.</p><h2 id="shift">التحوّل الذهني</h2><p>التحوّل الذهني هو الجزء الصعب — لكن ما إن يترسّخ حتى تختفي ألغاز «إنه يعمل على ذلك الخادم بالذات». ويصبح الدخول عبر SSH يدويًا للإصلاح أشبه بعطل لا بأسلوب عمل.</p>',
                'categories' => ['devops'],
                'toc' => [
                    ['pets', 'Servers as pets', 'Les serveurs comme animaux de compagnie', 'الخوادم كحيوانات أليفة'],
                    ['cattle', 'Servers as cattle', 'Les serveurs comme du bétail', 'الخوادم كماشية'],
                    ['shift', 'The mindset shift', 'Le changement de mentalité', 'التحوّل الذهني'],
                ],
                'related' => ['why-your-aws-bill-is-high', 'kubernetes-is-overkill-until-its-not'],
            ],
            [
                'slug' => 'why-your-microservices-feel-slower',
                'is_featured' => false,
                'read_time' => 6,
                'published_at' => '2026-02-21 13:10:00',
                'cover' => '/assets/blogs/blog9.png',
                'title_en' => 'The Real Reason Your Microservices Feel Slower',
                'title_fr' => 'La vraie raison pour laquelle vos microservices semblent plus lents',
                'title_ar' => 'السبب الحقيقي وراء شعورك بأن خدماتك المصغّرة أبطأ',
                'excerpt_en' => 'Distributed systems don\'t remove complexity — they move it.',
                'excerpt_fr' => 'Les systèmes distribués ne suppriment pas la complexité — ils la déplacent.',
                'excerpt_ar' => 'الأنظمة الموزّعة لا تزيل التعقيد — بل تنقله.',
                'body_en' => '<h2 id="relocate">Complexity moves, it doesn\'t vanish</h2><p>Teams split a monolith into microservices expecting speed and simplicity, then wonder why everything feels harder. The truth is that microservices don\'t delete complexity — they relocate it from inside your code to the network between services.</p><h2 id="network">The network is the new bottleneck</h2><p>A function call that used to be instant is now a network request that can be slow, fail or time out. Debugging spans five services and three logs. You\'ve traded code complexity for operational complexity, and that trade is only worth it at scale, for large teams that need to deploy independently.</p><h2 id="monolith">Start with a monolith</h2><p>For a small team building an MVP it\'s a terrible deal. Start with a well-organised monolith, and split out a service only when a clear boundary and a real scaling need appear together.</p>',
                'body_fr' => '<h2 id="relocate">La complexité se déplace, elle ne disparaît pas</h2><p>Les équipes découpent un monolithe en microservices en espérant vitesse et simplicité, puis se demandent pourquoi tout devient plus difficile. La vérité, c\'est que les microservices ne suppriment pas la complexité — ils la déplacent de l\'intérieur de votre code vers le réseau entre les services.</p><h2 id="network">Le réseau est le nouveau goulot d\'étranglement</h2><p>Un appel de fonction autrefois instantané est désormais une requête réseau qui peut être lente, échouer ou expirer. Le débogage s\'étale sur cinq services et trois journaux. Vous avez échangé la complexité du code contre la complexité opérationnelle, et cet échange ne vaut le coup qu\'à grande échelle, pour de grandes équipes qui doivent déployer indépendamment.</p><h2 id="monolith">Commencez par un monolithe</h2><p>Pour une petite équipe qui construit un MVP, c\'est un mauvais marché. Commencez par un monolithe bien organisé, et n\'extrayez un service que lorsqu\'une frontière claire et un vrai besoin de mise à l\'échelle apparaissent ensemble.</p>',
                'body_ar' => '<h2 id="relocate">التعقيد ينتقل ولا يختفي</h2><p>تقسّم الفرق النظام المتجانس إلى خدمات مصغّرة توقّعًا للسرعة والبساطة، ثم تتساءل لماذا صار كل شيء أصعب. الحقيقة أن الخدمات المصغّرة لا تحذف التعقيد — بل تنقله من داخل كودك إلى الشبكة بين الخدمات.</p><h2 id="network">الشبكة هي عنق الزجاجة الجديد</h2><p>استدعاء دالة كان فوريًا صار الآن طلبًا شبكيًا قد يكون بطيئًا أو يفشل أو تنتهي مهلته. ويمتدّ تتبّع الأخطاء عبر خمس خدمات وثلاثة سجلّات. لقد استبدلت تعقيد الكود بتعقيد التشغيل، وهذه المقايضة لا تستحقّ إلا على نطاق واسع، ولفرق كبيرة تحتاج إلى النشر باستقلالية.</p><h2 id="monolith">ابدأ بنظام متجانس</h2><p>بالنسبة لفريق صغير يبني منتجًا أوليًا، إنها صفقة سيّئة. ابدأ بنظام متجانس منظّم جيدًا، ولا تفصل خدمةً إلا حين يظهر حدّ واضح وحاجة توسّع حقيقية معًا.</p>',
                'categories' => ['web-dev', 'devops'],
                'toc' => [
                    ['relocate', 'Complexity moves, it doesn\'t vanish', 'La complexité se déplace, elle ne disparaît pas', 'التعقيد ينتقل ولا يختفي'],
                    ['network', 'The network is the new bottleneck', 'Le réseau est le nouveau goulot d\'étranglement', 'الشبكة هي عنق الزجاجة الجديد'],
                    ['monolith', 'Start with a monolith', 'Commencez par un monolithe', 'ابدأ بنظام متجانس'],
                ],
                'related' => ['kubernetes-is-overkill-until-its-not', 'the-mlops-gap-nobody-warns-you-about'],
            ],
            [
                'slug' => 'git-habits-juniors-vs-seniors',
                'is_featured' => true,
                'read_time' => 5,
                'published_at' => '2026-02-04 10:00:00',
                'cover' => '/assets/blogs/blog10.png',
                'title_en' => '5 Git Habits That Separate Juniors From Seniors',
                'title_fr' => '5 habitudes Git qui séparent les juniors des seniors',
                'title_ar' => '5 عادات في Git تفصل المبتدئين عن المحترفين',
                'excerpt_en' => 'It\'s not about knowing more commands. It\'s about communicating.',
                'excerpt_fr' => 'Ce n\'est pas une question de connaître plus de commandes. C\'est une question de communication.',
                'excerpt_ar' => 'المسألة ليست معرفة أوامر أكثر، بل التواصل.',
                'body_en' => '<h2 id="story">Commits that tell a story</h2><p>Senior engineers don\'t use fancier Git commands — they use Git as a communication tool. First, small focused commits that each do one thing, so the history reads like a story. Second, commit messages that explain <em>why</em>, not what — the diff already shows what.</p><h2 id="review">Make the pull request reviewable</h2><p>Third, they clean up messy local history with a rebase before opening a PR, so reviewers see intent rather than fumbling. Fourth, meaningful branch names and small pull requests that someone can actually review in one sitting.</p><h2 id="safety">Respect shared history</h2><p>Fifth, they never force-push to shared branches. None of this is advanced — it\'s the difference between treating Git as a save button and treating it as a record other humans will read. Adopt these and your reviews get faster and your team trusts your code more.</p>',
                'body_fr' => '<h2 id="story">Des commits qui racontent une histoire</h2><p>Les ingénieurs seniors n\'utilisent pas des commandes Git plus sophistiquées — ils utilisent Git comme un outil de communication. Premièrement, de petits commits ciblés qui ne font qu\'une chose, pour que l\'historique se lise comme une histoire. Deuxièmement, des messages de commit qui expliquent <em>pourquoi</em>, pas quoi — le diff montre déjà le quoi.</p><h2 id="review">Rendre la pull request relisible</h2><p>Troisièmement, ils nettoient un historique local en désordre par un rebase avant d\'ouvrir une PR, pour que les relecteurs voient l\'intention plutôt que les tâtonnements. Quatrièmement, des noms de branche parlants et de petites pull requests que quelqu\'un peut réellement relire d\'une traite.</p><h2 id="safety">Respecter l\'historique partagé</h2><p>Cinquièmement, ils ne font jamais de force-push sur des branches partagées. Rien de tout cela n\'est avancé — c\'est la différence entre traiter Git comme un bouton de sauvegarde et le traiter comme un registre que d\'autres humains liront. Adoptez ces habitudes et vos revues s\'accélèrent, et votre équipe fait davantage confiance à votre code.</p>',
                'body_ar' => '<h2 id="story">التزامات تحكي قصة</h2><p>لا يستخدم المهندسون المحترفون أوامر Git أكثر تعقيدًا — بل يستخدمون Git أداةَ تواصل. أولًا، التزامات صغيرة مركّزة يفعل كلٌّ منها شيئًا واحدًا، ليُقرأ التاريخ كقصة. ثانيًا، رسائل التزام تشرح <em>لماذا</em> لا ماذا — فالفرق (diff) يُظهر الماذا أصلًا.</p><h2 id="review">اجعل طلب الدمج قابلًا للمراجعة</h2><p>ثالثًا، ينظّفون التاريخ المحلي الفوضوي عبر rebase قبل فتح طلب الدمج، ليرى المراجعون النيّة لا التخبّط. رابعًا، أسماء فروع ذات معنى وطلبات دمج صغيرة يمكن لأحدهم مراجعتها فعلًا في جلسة واحدة.</p><h2 id="safety">احترم التاريخ المشترك</h2><p>خامسًا، لا يدفعون قسرًا (force-push) إلى الفروع المشتركة أبدًا. لا شيء من هذا متقدّم — إنه الفرق بين معاملة Git كزرّ حفظ ومعاملته كسجلّ سيقرأه بشر آخرون. تبنَّ هذه العادات فتتسارع مراجعاتك ويزداد وثوق فريقك بكودك.</p>',
                'categories' => ['career', 'tutorials'],
                'toc' => [
                    ['story', 'Commits that tell a story', 'Des commits qui racontent une histoire', 'التزامات تحكي قصة'],
                    ['review', 'Make the pull request reviewable', 'Rendre la pull request relisible', 'اجعل طلب الدمج قابلًا للمراجعة'],
                    ['safety', 'Respect shared history', 'Respecter l\'historique partagé', 'احترم التاريخ المشترك'],
                ],
                'related' => ['cicd-in-plain-english', 'stop-writing-bash-scripts-like-2005'],
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

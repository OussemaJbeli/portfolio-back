<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Contact section config and a handful of sample inbox messages (mixed
 * read/unread) so the admin inbox isn't empty in a demo.
 */
class ContactSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        // ── Contact section (details + subtext; defaults cover labels/CTA) ─
        DB::table('contact_section')->updateOrInsert(
            ['id' => 1],
            [
                'subtext_en' => 'Have a project in mind or just want to say hello? My inbox is always open.',
                'subtext_fr' => 'Un projet en tête ou juste envie de dire bonjour ? Ma boîte de réception est toujours ouverte.',
                'subtext_ar' => 'لديك مشروع في ذهنك أو تريد فقط إلقاء التحية؟ صندوق الوارد لديّ مفتوح دائمًا.',
                'email' => 'hello@oussemajbeli.dev',
                'phone' => '+216 20 000 000',
                'location_en' => 'Tunis, Tunisia',
                'location_fr' => 'Tunis, Tunisie',
                'location_ar' => 'تونس، تونس',
                'updated_at' => $now, 'created_at' => $now,
            ]
        );

        // ── Sample inbox messages ─────────────────────────────────────────
        $messages = [
            [
                'sender_name' => 'Sarah Müller',
                'sender_email' => 'sarah.muller@example.com',
                'subject' => 'Project inquiry — SaaS dashboard',
                'message' => "Hi Oussema,\n\nWe're a small startup looking to build a Vue + Laravel dashboard. Are you available for a 2-month engagement starting next month?\n\nBest,\nSarah",
                'is_read' => false,
                'days_ago' => 1,
            ],
            [
                'sender_name' => 'Karim Bouaziz',
                'sender_email' => 'karim.bouaziz@example.com',
                'subject' => 'Question about your CMS article',
                'message' => "Salut ! J'ai lu ton article sur le CMS trilingue, vraiment clair. Comment gères-tu le fallback quand une traduction manque ?",
                'is_read' => false,
                'days_ago' => 2,
            ],
            [
                'sender_name' => 'Acme Studio',
                'sender_email' => 'projects@acme.studio',
                'subject' => 'Freelance contract — e-commerce API',
                'message' => "Hello,\n\nWe liked the ShopNest case study. Could you send your rates and availability for a REST API project?",
                'is_read' => true,
                'days_ago' => 6,
            ],
            [
                'sender_name' => 'Lina Haddad',
                'sender_email' => 'lina.haddad@example.com',
                'subject' => null,
                'message' => 'مرحبًا أسامة، أعجبني عملك كثيرًا. هل تقدّم استشارات تقنية قصيرة؟',
                'is_read' => true,
                'days_ago' => 9,
            ],
            [
                'sender_name' => 'Tom Becker',
                'sender_email' => 'tom.becker@example.com',
                'subject' => 'Speaking at our meetup?',
                'message' => "Hi! We run a monthly web-dev meetup and would love a talk on Laravel + Vue. Interested?",
                'is_read' => true,
                'days_ago' => 14,
            ],
        ];

        foreach ($messages as $m) {
            DB::table('contact_messages')->updateOrInsert(
                ['sender_email' => $m['sender_email']],
                [
                    'sender_name' => $m['sender_name'],
                    'subject' => $m['subject'],
                    'message' => $m['message'],
                    'is_read' => $m['is_read'],
                    'created_at' => $now->copy()->subDays($m['days_ago']),
                ]
            );
        }
    }
}

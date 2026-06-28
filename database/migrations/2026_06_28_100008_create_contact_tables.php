<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Contact: the singleton section config (info, form labels, CTA banner copy)
 * and the visitor message submissions inbox.
 */
return new class extends Migration
{
    public function up(): void
    {
        // 24. CONTACT SECTION — info block, form labels, CTA banner (singleton).
        Schema::create('contact_section', function (Blueprint $table) {
            $table->id();
            $table->string('section_badge_en', 80)->default('> CONTACT');
            $table->string('section_badge_fr', 80)->default('> CONTACT');
            $table->string('section_badge_ar', 80)->default('> التواصل');
            $table->string('heading_en', 160)->default('Contact Me');
            $table->string('heading_fr', 160)->default('Contactez-moi');
            $table->string('heading_ar', 160)->default('تواصل معي');
            $table->text('subtext_en')->nullable();
            $table->text('subtext_fr')->nullable();
            $table->text('subtext_ar')->nullable();

            $table->string('email', 255)->nullable();
            $table->string('phone', 50)->nullable();
            $table->string('location_en', 200)->nullable();
            $table->string('location_fr', 200)->nullable();
            $table->string('location_ar', 200)->nullable();
            $table->string('availability_en', 200)->default('Freelance / Full-time');
            $table->string('availability_fr', 200)->default('Freelance / Temps plein');
            $table->string('availability_ar', 200)->default('عمل حر / دوام كامل');

            // Form field labels
            $table->string('label_name_en', 80)->default('Your Name');
            $table->string('label_name_fr', 80)->default('Votre nom');
            $table->string('label_name_ar', 80)->default('اسمك');
            $table->string('label_email_en', 80)->default('Your Email');
            $table->string('label_email_fr', 80)->default('Votre e-mail');
            $table->string('label_email_ar', 80)->default('بريدك الإلكتروني');
            $table->string('label_subject_en', 80)->default('Subject');
            $table->string('label_subject_fr', 80)->default('Sujet');
            $table->string('label_subject_ar', 80)->default('الموضوع');
            $table->string('label_message_en', 80)->default('Your Message');
            $table->string('label_message_fr', 80)->default('Votre message');
            $table->string('label_message_ar', 80)->default('رسالتك');
            $table->string('label_send_en', 80)->default('Send Message');
            $table->string('label_send_fr', 80)->default('Envoyer');
            $table->string('label_send_ar', 80)->default('إرسال');

            // "Interested in working together?" CTA banner (bottom of project detail)
            $table->string('cta_banner_heading_en', 200)->default('Interested in working together?');
            $table->string('cta_banner_heading_fr', 200)->default('Intéressé à travailler ensemble ?');
            $table->string('cta_banner_heading_ar', 200)->default('مهتم بالعمل معاً؟');
            $table->string('cta_banner_sub_en', 300)->default("Let's build something amazing together.");
            $table->string('cta_banner_sub_fr', 300)->default("Construisons quelque chose d'incroyable ensemble.");
            $table->string('cta_banner_sub_ar', 300)->default('لنبني شيئًا رائعًا معًا.');
            $table->string('cta_banner_btn_en', 80)->default('Contact Me →');
            $table->string('cta_banner_btn_fr', 80)->default('Contactez-moi →');
            $table->string('cta_banner_btn_ar', 80)->default('تواصل معي →');

            $table->timestamps();
        });

        // 25. CONTACT MESSAGES — form submissions from visitors.
        Schema::create('contact_messages', function (Blueprint $table) {
            $table->id();
            $table->string('sender_name', 200);
            $table->string('sender_email', 255);
            $table->string('subject', 300)->nullable();
            $table->text('message');
            $table->boolean('is_read')->default(false);
            $table->timestamp('created_at')->useCurrent();

            $table->index('is_read', 'idx_msg_read');
            $table->index('created_at', 'idx_msg_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contact_messages');
        Schema::dropIfExists('contact_section');
    }
};

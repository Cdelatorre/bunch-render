<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('general_settings', function (Blueprint $table) {
            $table->bigIncrements('id');

            /* ─────────── Datos básicos ─────────── */
            $table->string('site_name', 120);
            $table->string('site_title', 120)->nullable();
            $table->string('email_from', 150)->nullable();

            /* moneda y símbolo       (€ / USD / …) */
            $table->string('cur_text', 20)->default('EUR');
            $table->string('cur_sym', 10)->default('€');

            /* Colores del front (hex sin #) */
            $table->char('base_color', 6)->default('008d9d');
            $table->char('secondary_color', 6)->default('000000');

            $table->string('site_currency', 10)->default('EUR');

            /* plantilla activa y secciones de la home */
            $table->string('active_template', 40)->default('default');
            $table->tinyInteger('homesection')->default(1);   // Section One / Two …

            /* ─────────── Flags booleanos ─────────── */
            $table->boolean('maintenance_mode')->default(false);
            $table->boolean('force_ssl')->default(false);

            /* verificación / registro */
            $table->boolean('kv')->default(false);   // KYC obligatorio
            $table->boolean('ev')->default(false);   // email verification
            $table->boolean('sv')->default(false);   // sms verification
            $table->boolean('tv')->default(false);   // 2FA (no usado en controller pero lo dejamos)
            $table->boolean('en')->default(true);    // email notification
            $table->boolean('sn')->default(false);   // sms notification
            $table->boolean('secure_password')->default(false);
            $table->boolean('registration')->default(true);
            $table->boolean('agree')->default(false);

            /* ─────────── Configs JSON ─────────── */
            $table->json('mail_config')->nullable();
            $table->json('socialite_credentials')->nullable();
            $table->json('data_values')->nullable();     // extra key-value

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('general_settings');
    }
};

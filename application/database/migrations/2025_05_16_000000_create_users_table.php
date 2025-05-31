<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            /* ───── Identificación ───── */
            $table->bigIncrements('id');
            $table->string('firstname', 100)->nullable();
            $table->string('lastname', 100)->nullable();
            $table->string('username', 100)->unique();
            $table->string('email', 150)->unique();
            $table->string('mobile', 40)->nullable();      // nº móvil sin prefijo
            $table->string('country_code', 10)->nullable(); // ES, FR, …

            /* ───── Autenticación ───── */
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password', 255);
            $table->string('ver_code', 10)->nullable();          // código 6-dígitos
            $table->timestamp('ver_code_send_at')->nullable();   // cuándo se envió
            $table->tinyInteger('ev')->default(0);  // email verificado
            $table->tinyInteger('sv')->default(0);  // sms  verificado
            $table->tinyInteger('tv')->default(0);  // 2-FA verificado
            $table->tinyInteger('ts')->default(0);  // 2-step activado
            $table->string('tsc', 32)->nullable();  // secret key google-auth

            /* ───── Relación / referencia ───── */
            $table->unsignedBigInteger('ref_by')->nullable(); // referido
            $table->tinyInteger('gm')->default(0);            // 0 = user, 1 = gym
            $table->tinyInteger('reg_step')->default(0);      // 0 = datos faltan

            /* ───── Datos de perfil ───── */
            $table->string('image', 255)->nullable(); // avatar
            $table->json('address')->nullable();      // { street, locality, … }
            $table->decimal('balance', 12, 2)->default(0);
            $table->decimal('avg_review', 3, 2)->default(0);
            $table->integer('review_count')->default(0);

            /* ───── KYC ───── */
            $table->json('kyc_data')->nullable();
            $table->tinyInteger('kv')->default(0);      // 0=pending 1=ok 2=pending

            /* ───── Estado ───── */
            $table->tinyInteger('status')->default(1);  // 0=baneado 1=activo 2=borrado
            $table->string('ban_reason', 255)->nullable();

            /* ───── Meta & seguridad ───── */
            $table->string('browser', 120)->nullable();
            $table->string('os', 120)->nullable();
            $table->ipAddress('ip')->nullable();
            $table->string('token', 64)->nullable(); // remember / API

            $table->timestamps();

            /* ─── índices útiles ─── */
            $table->index(['mobile']);
            $table->index(['ref_by']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};

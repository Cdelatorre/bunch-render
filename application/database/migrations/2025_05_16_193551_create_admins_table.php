<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Crea la tabla admins.
     */
    public function up(): void
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->bigIncrements('id');

            /* ─────── credenciales ─────── */
            $table->string('username', 60)->unique();
            $table->string('email', 120)->unique()->nullable();
            $table->string('password');

            /* ─────── info de perfil ───── */
            $table->string('name', 120)->nullable();       // ⬅️ añadido
            $table->string('image', 255)->nullable();      // ⬅️ añadido

            /* ─────── extras ───────────── */
            $table->boolean('is_super')->default(false);   // super-admin
            $table->rememberToken();                       // “recuerdame”

            $table->timestamps();
        });
    }

    /**
     * Revierte la migración.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};

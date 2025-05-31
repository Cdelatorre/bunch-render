<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_logins', function (Blueprint $table) {
            $table->bigIncrements('id');

            /* relación con users */
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->cascadeOnDelete();

            /* datos del login */
            $table->string('user_ip', 45)->nullable();          // IPv4 / IPv6
            $table->string('browser', 120)->nullable();
            $table->string('os', 120)->nullable();

             $table->string('city', 120)->nullable()->change();
            $table->string('country_code', 10)->nullable()->change();
            $table->string('country', 120)->nullable()->change();

            /* para la sección de gráficas */
           $table->string('longitude', 50)->nullable()->change();
            $table->string('latitude', 50)->nullable()->change();

            $table->timestamps();       // ← created_at = “Login at”
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_logins');
    }
};

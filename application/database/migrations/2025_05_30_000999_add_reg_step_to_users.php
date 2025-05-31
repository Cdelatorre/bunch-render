<?php
// database/migrations/2025_05_30_000999_add_reg_step_to_users.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // solo la creamos si no existe
            if (! Schema::hasColumn('users', 'reg_step')) {
                $table->tinyInteger('reg_step')
                      ->default(0)          // 0 = datos pendientes | 1 = completo
                      ->after('kv');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('reg_step');
        });
    }
};

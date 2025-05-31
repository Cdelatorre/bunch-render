<?php
// 2025_06_02_190000_add_verification_columns_to_users.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            // código de verificación (6-8 dígitos). Lo dejamos como string(10)
            if (!Schema::hasColumn('users', 'ver_code')) {
                $table->string('ver_code', 10)->nullable()->after('kv');
            }

            // fecha/hora de envío de ese código
            if (!Schema::hasColumn('users', 'ver_code_send_at')) {
                $table->timestamp('ver_code_send_at')->nullable()->after('ver_code');
            }

            // “tv”: two-factor verification superada (0 = pendiente, 1 = ok)
            if (!Schema::hasColumn('users', 'tv')) {
                $table->boolean('tv')->default(0)->after('ts');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['ver_code', 'ver_code_send_at', 'tv']);
        });
    }
};

<?php
// database/migrations/2025_06_01_120000_add_mobile_and_address_to_users_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // ↓↓↓ se añaden solo si no existen (evita error al volver a correr)
            if (!Schema::hasColumn('users', 'mobile')) {
                $table->string('mobile', 40)->unique()->nullable()->after('email');
            }
            if (!Schema::hasColumn('users', 'address')) {
                $table->json('address')->nullable()->after('mobile');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['mobile', 'address']);
        });
    }
};

<?php
// database/migrations/2025_06_02_000000_add_verification_and_ban_fields_to_users_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            // ─── flags de verificación ─────────────────────────────
            if (!Schema::hasColumn('users', 'ev'))  $table->boolean('ev')->default(0)->after('address'); // email verified
            if (!Schema::hasColumn('users', 'sv'))  $table->boolean('sv')->default(0)->after('ev');       // sms verified
            if (!Schema::hasColumn('users', 'ts'))  $table->boolean('ts')->default(0)->after('sv');       // two-step (2FA)
            if (!Schema::hasColumn('users', 'kv'))  $table->boolean('kv')->default(0)->after('ts');       // KYC verified

            // ─── datos KYC ─────────────────────────────────────────
            if (!Schema::hasColumn('users', 'kyc_data'))
                $table->json('kyc_data')->nullable()->after('kv');

            // ─── motivo de baneo ───────────────────────────────────
            if (!Schema::hasColumn('users', 'ban_reason'))
                $table->string('ban_reason', 255)->nullable()->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'ev', 'sv', 'ts', 'kv',
                'kyc_data',
                'ban_reason',
            ]);
        });
    }
};

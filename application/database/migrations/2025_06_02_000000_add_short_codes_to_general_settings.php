<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('general_settings', function (Blueprint $table) {
            if (!Schema::hasColumn('general_settings', 'global_shortcodes')) {
                $table->json('global_shortcodes')
                      ->nullable()
                      ->after('socialite_credentials')
                      ->comment('Short-codes disponibles en todas las plantillas');
            }
        });
    }

    public function down(): void
    {
        Schema::table('general_settings', function (Blueprint $table) {
            $table->dropColumn('global_shortcodes');
        });
    }
};

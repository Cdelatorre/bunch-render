<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('notification_templates', function (Blueprint $table) {
            if (!Schema::hasColumn('notification_templates', 'shortcodes')) {
                $table->json('shortcodes')->nullable()
                      ->after('sms_status')
                      ->comment('Mapa de short-codes disponibles para la plantilla');
            }
        });
    }

    public function down(): void
    {
        Schema::table('notification_templates', function (Blueprint $table) {
            $table->dropColumn('shortcodes');
        });
    }
};

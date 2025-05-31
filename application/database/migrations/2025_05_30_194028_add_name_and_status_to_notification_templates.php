<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('notification_templates', function (Blueprint $table) {
            // Si ya existiera la columna por cualquier motivo, evitamos el error
            if (!Schema::hasColumn('notification_templates', 'name')) {
                $table->string('name', 255)
                      ->after('act')
                      ->default('')->index();
            }

            if (!Schema::hasColumn('notification_templates', 'status')) {
                $table->tinyInteger('status')
                      ->after('name')
                      ->default(1)
                      ->comment('1 = activa | 0 = inactiva');
            }
        });
    }

    public function down(): void
    {
        Schema::table('notification_templates', function (Blueprint $table) {
            $table->dropColumn(['name', 'status']);
        });
    }
};

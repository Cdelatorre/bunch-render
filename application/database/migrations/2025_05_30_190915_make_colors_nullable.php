<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('general_settings', function (Blueprint $table) {
            $table->char('base_color', 6)->nullable()->change();
            $table->char('secondary_color', 6)->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('general_settings', function (Blueprint $table) {
            $table->char('base_color', 6)->default('008d9d')->nullable(false)->change();
            $table->char('secondary_color', 6)->default('000000')->nullable(false)->change();
        });
    }
};

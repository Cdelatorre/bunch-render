<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('images', function (Blueprint $table) {
            // Orden de aparición (0 = principal).  TinyInt evita índices grandes.
            $table->unsignedTinyInteger('priority')
                  ->default(0)
                  ->after('image');
        });
    }

    public function down(): void
    {
        Schema::table('images', function (Blueprint $table) {
            $table->dropColumn('priority');
        });
    }
};

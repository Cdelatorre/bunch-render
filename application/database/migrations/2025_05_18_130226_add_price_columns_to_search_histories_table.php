<?php
// database/migrations/2025_05_18_150000_add_price_columns_to_search_histories_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        /**
         * Añadimos las columnas que el dashboard necesita.
         *  - min_price  →  precio más bajo encontrado para la búsqueda
         *  - max_price  →  precio más alto encontrado para la búsqueda
         */
        Schema::table('search_histories', function (Blueprint $table) {
            if (!Schema::hasColumn('search_histories', 'min_price')) {
                $table->decimal('min_price', 8, 2)->nullable()->after('search_count');
            }
            if (!Schema::hasColumn('search_histories', 'max_price')) {
                $table->decimal('max_price', 8, 2)->nullable()->after('min_price');
            }
        });
    }

    public function down(): void
    {
        Schema::table('search_histories', function (Blueprint $table) {
            $table->dropColumn(['min_price', 'max_price']);
        });
    }
};

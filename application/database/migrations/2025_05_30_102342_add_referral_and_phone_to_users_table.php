<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            // ----- Referidos -----
            if (!Schema::hasColumn('users', 'ref_by')) {
                $table->unsignedBigInteger('ref_by')
                      ->nullable()
                      ->after('username');

                // opcional: clave foránea a la propia tabla
                // $table->foreign('ref_by')
                //       ->references('id')
                //       ->on('users')
                //       ->nullOnDelete();
            }

            // ----- Teléfono y país -----
            if (!Schema::hasColumn('users', 'country_code')) {
                $table->string('country_code', 5)
                      ->nullable()
                      ->after('ref_by');
            }

            if (!Schema::hasColumn('users', 'mobile')) {
                $table->string('mobile', 30)
                      ->nullable()
                      ->after('country_code');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['ref_by', 'country_code', 'mobile']);
        });
    }
};

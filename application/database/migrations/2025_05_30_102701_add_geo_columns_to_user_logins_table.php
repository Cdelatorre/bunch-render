<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('user_logins', function (Blueprint $table) {

            if (!Schema::hasColumn('user_logins', 'longitude')) {
                $table->string('longitude', 50)->nullable()->after('user_id');
            }

            if (!Schema::hasColumn('user_logins', 'latitude')) {
                $table->string('latitude', 50)->nullable()->after('longitude');
            }

            if (!Schema::hasColumn('user_logins', 'city')) {
                $table->string('city', 100)->nullable()->after('latitude');
            }

            if (!Schema::hasColumn('user_logins', 'country_code')) {
                $table->string('country_code', 10)->nullable()->after('city');
            }

            if (!Schema::hasColumn('user_logins', 'country')) {
                $table->string('country', 100)->nullable()->after('country_code');
            }

            // columnas de entorno de dispositivo si todavía no existen
            if (!Schema::hasColumn('user_logins', 'browser')) {
                $table->string('browser', 120)->nullable()->after('country');
            }

            if (!Schema::hasColumn('user_logins', 'os')) {
                $table->string('os', 120)->nullable()->after('browser');
            }

            if (!Schema::hasColumn('user_logins', 'user_ip')) {
                $table->string('user_ip', 45)->nullable()->after('os');
            }
        });
    }

    public function down(): void
    {
        Schema::table('user_logins', function (Blueprint $table) {
            $table->dropColumn([
                'longitude', 'latitude', 'city',
                'country_code', 'country', 'browser',
                'os', 'user_ip'
            ]);
        });
    }
};

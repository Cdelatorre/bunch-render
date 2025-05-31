<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /* ───── 1. Tabla notification_logs  ───── */
        if (!Schema::hasTable('notification_logs')) {
            Schema::create('notification_logs', function (Blueprint $table) {
                $table->bigIncrements('id');

                // Relación con users (opcional)
                $table->unsignedBigInteger('user_id')->nullable()->index();

                $table->string('notification_type', 40)->nullable(); // email, sms, push…
                $table->string('sender', 80)->nullable();            // php, smtp …
                $table->string('sent_from', 120)->nullable();
                $table->string('sent_to', 120)->nullable();
                $table->string('subject', 255)->nullable();
                $table->mediumText('message')->nullable();

                $table->timestamps();
            });
        }

        /* ───── 2. Ampliar admin_notifications.title  ───── */
        if (Schema::hasTable('admin_notifications') &&
            Schema::hasColumn('admin_notifications', 'title')) {

            Schema::table('admin_notifications', function (Blueprint $table) {
                // lo cambiamos de VARCHAR(??) a TEXT
                $table->text('title')->change();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('notification_logs');

        if (Schema::hasTable('admin_notifications') &&
            Schema::hasColumn('admin_notifications', 'title')) {

            Schema::table('admin_notifications', function (Blueprint $table) {
                // volver a string(255); ajusta si originalmente era distinto
                $table->string('title', 255)->change();
            });
        }
    }
};

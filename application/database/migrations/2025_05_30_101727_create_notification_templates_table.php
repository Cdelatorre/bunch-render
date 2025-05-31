<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notification_templates', function (Blueprint $table) {
            $table->bigIncrements('id');

            /*  Clave interna que el código busca con ->where('act', …)  */
            $table->string('act', 60)->unique();

            /*  Flags: email_status es el que usa NotifyProcess por defecto  */
            $table->tinyInteger('email_status')->default(1);   // 1 = activo
            $table->tinyInteger('sms_status')->default(0)->nullable();
            $table->tinyInteger('push_status')->default(0)->nullable();

            /*  Contenido  */
            $table->string('subj', 255)->nullable();     // asunto
            $table->mediumText('email_body')->nullable();
            $table->mediumText('sms_body')->nullable();
            $table->mediumText('push_body')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notification_templates');
    }
};

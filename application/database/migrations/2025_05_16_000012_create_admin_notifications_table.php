<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('admin_notifications', function (Blueprint $table) {
            $table->bigIncrements('id');

            // notificación relativa a un usuario (opcional)
            $table->foreignId('user_id')
                  ->nullable()
                  ->constrained()
                  ->nullOnDelete();

            $table->string('title', 120);
            $table->text('message')->nullable();

            // URL a la que se redirige al hacer clic
            $table->string('click_url')->default('#');

            // 0 = sin leer  |  1 = leída
            $table->boolean('read_status')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admin_notifications');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('support_tickets', function (Blueprint $table) {
            $table->bigIncrements('id');

            // Si el ticket pertenece a un usuario del sistema
            $table->foreignId('user_id')
                  ->nullable()
                  ->constrained()
                  ->cascadeOnDelete();

            $table->string('subject', 200);
            $table->text('message');
            /**
             * 0 = abierto - nuevo
             * 1 = contestado por admin
             * 2 = respondido por usuario
             * 3 = cerrado
             */
            $table->tinyInteger('status')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('support_tickets');
    }
};

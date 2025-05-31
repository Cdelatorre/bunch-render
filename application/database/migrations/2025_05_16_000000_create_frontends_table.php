<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('frontends', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('data_keys', 120);          // «homeone.content», «faq.element»…
            $table->json('data_values')->nullable();   // campo genérico para el contenido
            $table->tinyInteger('status')->default(1); // 1=visible
            $table->timestamps();

            $table->index('data_keys');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('frontends');
    }
};

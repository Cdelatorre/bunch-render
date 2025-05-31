<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_images', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();

            // Carpeta (p. ej. 2025/05) para no saturar un directorio y nombre del fichero
            $table->string('path', 120);     // carpeta relativa dentro de storage/app/public/product
            $table->string('image', 160);    // nombre del archivo
            $table->tinyInteger('priority')->default(0);   // por si quieres ordenar
             $table->boolean('is_main')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_images');
    }
};

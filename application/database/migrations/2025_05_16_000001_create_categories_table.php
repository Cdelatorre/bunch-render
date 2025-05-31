<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->bigIncrements('id');

            // orden deseado
            $table->string('name', 120);
            $table->string('banner', 255)->nullable();   // ← ya está detrás de name
            $table->string('icon', 255)->nullable();
            $table->string('slug')->unique();

            $table->unsignedBigInteger('parent_id')->nullable()->index();
            $table->tinyInteger('status')->default(1);

            $table->timestamps();

            // FK al final
            $table->foreign('parent_id')
                  ->references('id')->on('categories')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};

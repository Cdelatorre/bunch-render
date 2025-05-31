<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('search_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
                $table->foreignId('user_id')->constrained('users')->cascadeOnDelete()->nullable();
                $table->string('keyword', 180)->nullable();
                $table->json('activities')->nullable();
                $table->json('services')->nullable();
                $table->integer('search_count')->default(1);
                $table->string('city', 120)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('search_histories');
    }
};

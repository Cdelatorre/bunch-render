<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('frontend_sections', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('key', 120)->unique();
            $table->json('content')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('frontend_sections');
    }
};

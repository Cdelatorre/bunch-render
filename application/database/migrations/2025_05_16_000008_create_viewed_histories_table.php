<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('viewed_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
                $table->foreignId('user_id')->constrained('users')->cascadeOnDelete()->nullable();
                $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
                $table->string('ip', 45)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('viewed_histories');
    }
};

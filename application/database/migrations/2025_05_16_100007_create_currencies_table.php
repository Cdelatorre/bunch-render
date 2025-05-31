<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('currencies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code', 10)->unique();
            $table->string('name', 60);
            $table->decimal('rate', 12, 6)->default('1.000000');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('currencies');
    }
};

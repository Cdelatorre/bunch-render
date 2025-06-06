<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('forms', function (Blueprint $table) {
            $table->bigIncrements('id');
                $table->string('act', 60);
                $table->json('form_data');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('forms');
    }
};

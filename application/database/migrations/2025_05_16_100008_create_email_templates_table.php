<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('email_templates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('slug', 120)->unique();
            $table->string('subject', 150)->nullable();
            $table->text('body')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('email_templates');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('deposits', function (Blueprint $table) {
            $table->bigIncrements('id');
                $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
                $table->integer('method_code')->default(0);
                $table->decimal('amount', 12, 2);
                $table->tinyInteger('status')->default(0);
                $table->string('trx', 64);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('deposits');
    }
};

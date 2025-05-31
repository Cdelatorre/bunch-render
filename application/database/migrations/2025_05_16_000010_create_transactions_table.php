<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
                $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
                $table->decimal('amount', 12, 2);
                $table->decimal('post_balance', 12, 2);
                $table->decimal('charge', 12, 2)->default('0');
                $table->string('trx', 64);
                $table->char('trx_type', 1);
                $table->string('remark', 120)->nullable();
                $table->text('details')->nullable();
                $table->text('admin_feedback')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('transactions');
    }
};

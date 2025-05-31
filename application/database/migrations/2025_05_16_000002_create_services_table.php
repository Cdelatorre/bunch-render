<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->bigIncrements('id');

            /* ───────── datos principales ───────── */
            $table->string('name', 120);
            $table->text('description')->nullable();

            /* ───────── jerarquía + estado ──────── */
            $table->unsignedBigInteger('parent')->default(0)->index(); // sigue igual
            $table->tinyInteger('status')->default(1);

            $table->timestamps();

            /*  Clave foránea eliminada
            $table->foreign('parent')
                  ->references('id')->on('services')
                  ->onDelete('cascade');
            */
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};

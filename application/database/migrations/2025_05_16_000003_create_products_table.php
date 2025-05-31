<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');

            // relaciones
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->foreignId('category_id')->nullable()->constrained('categories')->cascadeOnDelete();
            $table->foreignId('service_id')->nullable()->constrained('services')->cascadeOnDelete();

            // datos básicos
            $table->string('title', 180);
            $table->string('slug', 200)->unique()->nullable();
            $table->text('description')->nullable();
            $table->text('short_description')->nullable(); // se usa en update()

            // contacto
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('website')->nullable();
            $table->text('social')->nullable(); // redes sociales
            $table->string('social_link')->nullable();
            $table->string('call_to_action')->nullable();

            // especificaciones
            $table->json('specification')->nullable();

            // localización
            $table->string('formatted_address', 255)->nullable();
            $table->json('address')->nullable();          // {lat, lng}
            $table->string('place_id', 100)->nullable();
            $table->json('schedules')->nullable();
            $table->json('rates')->nullable();

            // fechas
            $table->dateTime('started_at')->nullable();
            $table->dateTime('expired_at')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();

            // estadísticas
            $table->decimal('price', 10, 2)->default(0);
            $table->integer('bid_count')->default(0);
            $table->decimal('avg_review', 3, 2)->default(0);
            $table->integer('review_count')->default(0);
            $table->json('billing_address')->nullable();

            // estado
            $table->tinyInteger('status')->default(1); // 1=live, 0=inactive, etc.
            $table->tinyInteger('gm')->default(0);     // Gym Management flag
            $table->boolean('bid_complete')->default(false);

            // rating externo
            $table->decimal('google_rating', 3, 2)->nullable();
            $table->string('google_review_count')->nullable();           // ciudad
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

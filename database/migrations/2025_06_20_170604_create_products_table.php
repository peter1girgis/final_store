<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->constrained()->onDelete('cascade'); // البائع
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->string('main_image')->nullable(); // صورة أساسية
            $table->json('sub_images')->nullable();   // صور فرعية بصيغة JSON
            $table->decimal('old_price', 10, 2)->nullable(); // للسعر المخفض لو في عرض
            $table->integer('stock')->default(0); // عدد القطع المتاحة
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            // علاقات
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('store_id')->constrained()->onDelete('cascade');

            // JSON للمنتجات والكميات
            $table->json('products'); // يحتوي على [{"product_id":X, "quantity":Y}, ...]

            // تجميعي
            $table->unsignedInteger('total_quantity')->default(0);

            // الحالة
            $table->enum('state_of_order', ['waiting', 'in_processing', 'achieved'])->default('waiting');
            $table->enum('state_of_payment', ['pending', 'paid', 'failed'])->default('pending');

            // معلومات العميل
            $table->string('user_address');
            $table->string('user_phone_number');
            $table->string('user_email');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
}

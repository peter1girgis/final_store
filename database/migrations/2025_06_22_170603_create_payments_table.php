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
        Schema::create('payments', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->string('payment_id'); // Stripe session/payment id
        $table->string('product_names'); // products separated by comma
        $table->integer('total_quantity');
        $table->integer('amount'); // total paid amount
        $table->string('currency', 10);
        $table->string('payment_status');
        $table->integer('application_fee')->nullable(); // site commission
        $table->string('payment_method')->default('stripe');
        $table->string('stripe_store_account_id')->nullable(); // Stripe account of the store
        $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('seller_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->string('store_name');
            $table->string('store_logo')->nullable();
            $table->text('store_description')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();

            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('admin_feedback')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('seller_requests');
    }
};

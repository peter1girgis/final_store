<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('payments', function (Blueprint $table) {
        $table->unsignedBigInteger('store_id')->nullable()->after('user_id');

        // لو في علاقة foreign key
        $table->foreign('store_id')->references('id')->on('stores')->onDelete('set null');
    });
}

public function down()
{
    Schema::table('payments', function (Blueprint $table) {
        $table->dropForeign(['store_id']);
        $table->dropColumn('store_id');
    });
}

};

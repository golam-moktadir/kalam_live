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
        Schema::create('product_purchase_details', function (Blueprint $table) {
            $table->id('ser_id');
            $table->unsignedBigInteger('purchase_id')->comment('Foreign Key - purchase_id : product_purchases');
            $table->unsignedBigInteger('product_id')->comment('Foreign Key - product_id : products');
            $table->decimal('item_qty', 6, 2);
            $table->decimal('item_price', 8, 2);
            $table->decimal('total_price', 8, 2);
            $table->foreign('purchase_id')->references('purchase_id')->on('product_purchases');
            $table->foreign('product_id')->references('product_id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_purchase_details');
    }
};

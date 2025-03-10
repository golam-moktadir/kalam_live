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
        Schema::table('product_purchase_details', function (Blueprint $table) {
            $table->decimal('item_qty', 6,2)->default(0)->change(); 
            $table->decimal('item_price', 8,2)->default(0)->change(); 
            $table->decimal('total_price', 8,2)->default(0)->change(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_purchase_details', function (Blueprint $table) {
            $table->decimal('item_qty', 6,2)->change();
            $table->decimal('item_price', 8,2)->change(); 
            $table->decimal('total_price', 8,2)->change(); 
        });
    }
};

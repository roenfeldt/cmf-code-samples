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
        /**
         * This migration creates the 'products' table with the following fields:
         * - id: Primary key
         * - name: Product name (string)
         * - description: Product description (text, nullable)
         * - price: Product price (decimal, 10 digits total, 2 decimal places)
         * - stock: Stock quantity (integer, default 0)
         * - is_active: Active status (boolean, default true)
         * - timestamps: "Created at" and "Updated at" timestamps
         */
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->integer('stock')->default(0);
            $table->boolean('is_active')->default(true);
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

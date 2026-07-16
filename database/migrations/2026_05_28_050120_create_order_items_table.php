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
        Schema::create('order_items', function (Blueprint $table) {

            $table->id();

            $table->foreignId('order_id')
                  ->constrained()
                  ->onDelete('cascade');

            $table->foreignId('product_id')
                  ->constrained()
                  ->onDelete('cascade');

            // ─── SNAPSHOT — nilai ini tidak berubah meski produk diupdate ───

            // nama produk saat checkout
            $table->string('product_name');

            // harga produk saat checkout
            $table->decimal('price', 12, 2);

            // jumlah yang dibeli
            $table->unsignedInteger('qty');

            // foto saat checkout
            $table->string('product_image')->nullable();

            // subtotal = price × qty
            // dihitung di aplikasi, tidak disimpan di database

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
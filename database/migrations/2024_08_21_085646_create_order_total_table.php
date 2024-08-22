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
        Schema::create('order_total', function (Blueprint $table) {
            $table->id();
            $table->string('order_id')->nullable();
            $table->integer('type_payment')->default(1);
            $table->decimal('total_product', 15, 3)->default(0);
            $table->decimal('total_shipping_fee', 15, 3)->default(0);
            $table->decimal('exchange_points', 15, 3)->default(0);
            $table->decimal('total_payment', 15, 3)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_total');
    }
};

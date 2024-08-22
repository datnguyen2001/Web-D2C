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
            $table->string('name');
            $table->string('name_en');
            $table->string('slug');
            $table->string('sku')->nullable();
            $table->longText('describe')->nullable();
            $table->integer('category_id');
            $table->string('unit')->nullable();
            $table->string('en_unit')->nullable();
            $table->string('contact_info')->nullable();
            $table->integer('minimum_quantity')->default(1);
            $table->longText('src')->nullable();
            $table->integer('quantity')->default(1);
            $table->integer('shop_id')->nullable();
            $table->integer('display')->default(0);
            $table->integer('status')->default(0);
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

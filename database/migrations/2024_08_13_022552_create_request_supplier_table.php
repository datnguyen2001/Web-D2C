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
        Schema::create('request_supplier', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('name');
            $table->string('name_en');
            $table->string('slug');
            $table->longText('content')->nullable();
            $table->longText('content_en')->nullable();
            $table->string('phone');
            $table->string('quantity');
            $table->integer('scope');
            $table->date('date_end');
            $table->longText('src')->nullable();
            $table->integer('display')->default(1);
            $table->integer('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_supplier');
    }
};

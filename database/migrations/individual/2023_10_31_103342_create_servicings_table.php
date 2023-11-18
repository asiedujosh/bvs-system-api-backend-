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
        Schema::create('servicings', function (Blueprint $table) {
            $table->id();
            $table->string("productId");
            $table->foreign("productId")->references('productId')->on('products');
            $table->date("startDate")->nullable();
            $table->date("dueDate")->nullable();
            $table->decimal("amountPaid")->nullable();
            $table->string("serviceType");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servicings');
    }
};

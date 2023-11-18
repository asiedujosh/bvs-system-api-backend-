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
            $table->string("clientId");
            $table->foreign("clientId")->references('clientId')->on('clients');
            $table->string("productId")->unique();
            $table->string("carType");
            $table->string("carColor");
            $table->longText("carImage")->nullable();
            $table->string("plateNo");
            $table->string("chasisNo");
            $table->string("simNo");
            $table->string("deviceNo");
            $table->string("paymentMode");
            $table->string("purchaseType");
            $table->string("plateform");
            $table->date("requestDate");
            $table->string("action");
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

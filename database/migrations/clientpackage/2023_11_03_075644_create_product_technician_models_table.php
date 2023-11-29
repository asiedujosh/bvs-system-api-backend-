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
        Schema::create('product_technician_models', function (Blueprint $table) {
            $table->id();
            $table->string("productId");
            $table->date("actionDate");
            $table->string("supervisor");
            $table->string("technicalOfficer");
            $table->string("serviceType");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_technician_models');
    }
};

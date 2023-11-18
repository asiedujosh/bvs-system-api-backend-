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
        Schema::create('recording_tables', function (Blueprint $table) {
            $table->id();
            $table->string('productId');
            $table->string('clientId');
            $table->string('clientName');
            $table->string('clientTel')->nullable();
            $table->string('paymentMode')->nullable();
            $table->string('serviceOn')->nullable();
            $table->string('amtLastPaid')->nullable();
            $table->date('lastPaid')->nullable();
            $table->date('expiryDate')->nullable();
            $table->string('status')->nullable();
            $table->string('state');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recording_tables');
    }
};

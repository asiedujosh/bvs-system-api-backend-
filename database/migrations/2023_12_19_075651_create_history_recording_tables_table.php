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
        Schema::create('history_recording_tables', function (Blueprint $table) {
            $table->id();
            $table->string('productId');
            $table->string('clientId');
            $table->string('associate');
            $table->string('clientName');
            $table->string('clientLocation');
            $table->string('clientTel');
            $table->string('companyName')->nullable();
            $table->string('package')->nullable();
            $table->string('startDate')->nullable();
            $table->string('expireDate')->nullable();
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
        Schema::dropIfExists('history_recording_tables');
    }
};

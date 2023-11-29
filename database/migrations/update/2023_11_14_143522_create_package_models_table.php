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
        Schema::create('package_models', function (Blueprint $table) {
            $table->id();
            $table->string("packageName")->unique();
            $table->string("packagePrice");
            $table->string("packageMonth");
            $table->string("packageDetails");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('package_models');
    }
};

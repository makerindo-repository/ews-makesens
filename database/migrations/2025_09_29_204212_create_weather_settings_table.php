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
        Schema::create('weather_settings', function (Blueprint $table) {
            $table->id();
            $table->string('province_code', 20);
            $table->string('city_code', 20);
            $table->string('district_code', 20);
            $table->string('village_code', 20);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weather_settings');
    }
};

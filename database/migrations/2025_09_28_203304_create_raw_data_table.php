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
        Schema::create('raw_data', function (Blueprint $table) {
            $table->id();
            $table->string('battery_level');
            $table->decimal('latitude', 20, 15);
            $table->decimal('longitude', 20, 15);
            $table->decimal('distance');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('raw_data');
    }
};

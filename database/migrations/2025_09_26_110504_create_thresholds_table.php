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
        Schema::create('thresholds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('iot_node_id')->constrained('iot_nodes')->onDelete('cascade');
            $table->integer('waspada');
            $table->integer('siaga');
            $table->integer('awas');
            $table->integer('h2')->comment('Tinggi dari daratan ke dasar sungai');
            $table->integer('h1')->comment('Tinggi muka sensor terhadap daratan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('thresholds');
    }
};

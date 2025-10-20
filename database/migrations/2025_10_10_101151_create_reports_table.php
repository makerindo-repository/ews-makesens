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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->string('kode_laporan')->unique()->nullable();
            $table->string('jenis_kejadian');
            $table->date('tanggal_kejadian');
            $table->time('waktu_kejadian');
            $table->string('pelapor');
            $table->decimal('latitude', 20, 15);
            $table->decimal('longitude', 20, 15);
            $table->string('kelurahan');
            $table->string('kecamatan');
            $table->string('kabupaten_kota');
            $table->string('provinsi');
            $table->text('alamat_lengkap');
            $table->text('penyebab');
            $table->text('dampak');
            $table->longText('kronologi');
            $table->integer('pengungsi');
            $table->integer('luka_berat');
            $table->integer('luka_ringan');
            $table->integer('meninggal');
            $table->text('kebutuhan_mendesak');
            $table->text('kebutuhan_bantuan');
            $table->json('foto')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};

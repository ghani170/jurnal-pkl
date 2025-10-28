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
        Schema::create('kegiatans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_siswa')->constrained('users')->onDelete('cascade');
            $table->date('tanggal_kegiatan');
            $table->time('mulai_kegiatan');
            $table->time('akhir_kegiatan');
            $table->text('keterangan_kegiatan');
            $table->string('dokumentasi')->nullable();
            $table->text('catatan_pembimbing')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kegiatans');
    }
};

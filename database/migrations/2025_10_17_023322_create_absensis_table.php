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
        Schema::create('absensis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_siswa')->constrained('siswas')->onDelete('cascade');
            $table->time('jam_mulai')->nullable();
            $table->time('jam_akhir')->nullable();
            $table->date('tanggal_absen');
            $table->enum('status', ['sakit', 'hadir', 'izin', 'alpha', 'libur']);
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensis');
    }
};

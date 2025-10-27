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
        Schema::create('siswas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_siswa')->constrained('users')->onDelete('cascade');
            $table->string('nis_siswa')->unique();
            $table->foreignId('id_kelas')->nullable()->constrained('kelas')->nullOnDelete();
            $table->foreignId('id_jurusan')->nullable()->constrained('jurusans')->nullOnDelete();
            $table->foreignId('id_dudi')->nullable()->constrained('dudis')->nullOnDelete();
            $table->foreignId('id_pembimbing')->nullable()->constrained('users')->nullOnDelete();
            $table->enum('gender', ['laki_laki', 'perempuan'])->nullable();
            $table->string('no_telpon', 100)->nullable();
            $table->string('tempat_lahir', 100)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->text('alamat')->nullable();
            $table->string('golongan_darah', 10)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswas');
    }
};

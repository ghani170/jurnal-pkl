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
        Schema::create('dudis', function (Blueprint $table) {
            $table->id();
            $table->string('nama_dudi', 150);
            $table->string('jenis_usaha', 100);
            $table->text('alamat');
            $table->string('kontak', 100);
            $table->string('nama_pimpinan', 100);
            $table->string('nama_pembimbing', 100);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dudis');
    }
};

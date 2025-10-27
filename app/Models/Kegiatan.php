<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    protected $fillable = [
        'id_siswa',
        'tanggal_kegiatan',
        'mulai_kegiatan',
        'akhir_kegiatan',
        'keterangan_kegiatan',
        'dokumentasi',
        'catatan_pembimbing',
    ];

    public function siswa() {
        return $this->belongsTo(Kegiatan::class, 'id_siswa');
    }
}

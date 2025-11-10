<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    protected $table = 'absensis';
    protected $fillable = [
        'id_siswa',
        'jam_mulai',
        'jam_akhir',
        'tanggal_absen',
        'status',
        'keterangan',
    ];

    public function siswa(){
        return $this->belongsTo(Siswa::class, 'id_siswa');
    }
}

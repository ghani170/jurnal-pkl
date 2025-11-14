<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Siswa extends Model
{
    protected $fillable = [
        'id_siswa',
        'nis_siswa',
        'id_kelas',
        'id_jurusan',
        'id_dudi',
        'id_pembimbing',
        'gender',
        'no_telpon',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'golongan_darah',
        'foto',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'id_siswa');
    }
    public function siswa() {
        return $this->belongsTo(User::class, 'id_siswa');
    }

    public function pembimbing(){
        return $this->belongsTo(User::class, 'id_pembimbing');
    }

    public function kelas(){
        return $this->belongsTo(Kelas::class, 'id_kelas');
    }

    public function dudi(){
        return $this->belongsTo(Dudi::class, 'id_dudi');
    } 

    public function jurusan(){
        return $this->belongsTo(Jurusan::class, 'id_jurusan');
    }

    public function kegiatan(){
        return $this->hasMany(Kegiatan::class, 'id_siswa');
    }

    public function absensi(){
        return $this->hasMany(Absensi::class, 'id_siswa');
    }
}

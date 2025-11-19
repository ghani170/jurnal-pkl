<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dudi extends Model
{
    protected $table = 'dudis';
    protected $fillable = [
        'nama_dudi',
        'jenis_usaha',
        'alamat',
        'kontak',
        'nama_pimpinan',
        'nama_pembimbing',
    ];

    public function siswa(){
        return $this->hasMany(Siswa::class, 'id_dudi');
    }

}

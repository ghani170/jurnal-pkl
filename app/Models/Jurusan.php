<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    protected $fillable = [
        'jurusan',
    ];

    public function siswas()
    {
        return $this->hasMany(Siswa::class, 'id_siswa');
    }
}

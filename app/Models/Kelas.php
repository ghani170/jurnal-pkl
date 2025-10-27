<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $fillable = [
        'kelas',
    ];

    public function kelas(){
        return $this->hasMany(Siswa::class, 'id_siswa');
    }
}

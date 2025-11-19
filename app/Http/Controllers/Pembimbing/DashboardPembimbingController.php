<?php

namespace App\Http\Controllers\Pembimbing;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Kegiatan;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardPembimbingController extends Controller
{
    public function index(){
        $idPembimbing = Auth::id();

        $daftarKegiatan = Kegiatan::whereHas('siswa', function ($query) use ($idPembimbing) {
            $query->where('id_pembimbing', $idPembimbing);
        })->with('siswa')->get();

        $totalKegiatan = $daftarKegiatan->count();

        // ambil daftar dan total absensi
        $daftarAbsensi = Absensi::whereHas('siswa', function ($query) use ($idPembimbing) {
            $query->where('id_pembimbing', $idPembimbing);
        })->with('siswa')->get();

        // gunakan count() pada collection atau hitung langsung di DB:
        $totalAbsensi = $daftarAbsensi->count();

        $daftarSiswa = Siswa::whereHas('siswa', function ($query) use ($idPembimbing) {
            $query->where('id_pembimbing', $idPembimbing);
        })->with('siswa')->get();

        // gunakan count() pada collection atau hitung langsung di DB:
        $totalSiswa = $daftarSiswa->count();
        

        return view('pembimbing.dashboard', compact('daftarKegiatan', 'totalKegiatan', 'daftarAbsensi', 'totalAbsensi', 'daftarSiswa', 'totalSiswa'));
    }
}

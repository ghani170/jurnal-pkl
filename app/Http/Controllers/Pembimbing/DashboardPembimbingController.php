<?php

namespace App\Http\Controllers\Pembimbing;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Kegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardPembimbingController extends Controller
{
    public function index()
    {
        $idPembimbing = Auth::id(); // user pembimbing yang login

        // Ambil semua kegiatan siswa yang dibimbing pembimbing ini
        $daftarKegiatan = Kegiatan::whereHas('siswa', function ($query) use ($idPembimbing) {
            $query->where('id_pembimbing', $idPembimbing);
        })->with('siswa')->get(); // optional eager load siswa

        $totalKegiatan = $daftarKegiatan->count();

        $daftarAbsensi = Absensi::whereHas('siswa', function ($query) use ($idPembimbing){
            $query->where('id_pembimbing', $idPembimbing);
        })->with('siswa')->get();

        $totalAbsensi = $daftarAbsensi->count();
        return view('pembimbing.dashboard', compact('daftarKegiatan', 'totalKegiatan', 'daftarAbsensi', 'totalAbsensi'));
    }
}

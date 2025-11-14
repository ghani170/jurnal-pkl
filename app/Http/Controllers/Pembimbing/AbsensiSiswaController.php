<?php

namespace App\Http\Controllers\Pembimbing;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbsensiSiswaController extends Controller
{
    public function index(Request $request)
    {
       $absensis = Absensi::with('siswa')
            ->whereHas('siswa', function ($query) {
                $query->where('id_pembimbing', Auth::user()->id);
            });
            
        
        // 2. Tambahkan Filter Berdasarkan Nama Siswa
        if ($request->filled('nama_siswa')) {
            $namaSiswa = $request->input('nama_siswa');

            // Filter di relasi 'siswa' lalu ke relasi 'user' untuk mencari nama
            $absensis->whereHas('siswa.user', function ($query) use ($namaSiswa) {
                $query->where('name', 'like', '%' . $namaSiswa . '%');
            });
        }

        // 3. Tambahkan Filter Berdasarkan Tanggal Kegiatan
        if ($request->filled('tanggal')) {
            $absensis->whereDate('tanggal_absen', $request->input('tanggal'));
        }

        // 4. Eksekusi query dengan urutan dan pengambilan data
        $absensis = $absensis->orderBy('id', 'desc')->get();

        return view('pembimbing.absensisiswa.index', compact('absensis'));
    }
}

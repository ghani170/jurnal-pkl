<?php

namespace App\Http\Controllers\Pembimbing;

use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KegiatanSiswaController extends Controller
{
    public function index(Request $request)
    {
        
        $kegiatans = Kegiatan::query()
            ->whereHas('siswa', function ($query) {
                $query->where('id_pembimbing', Auth::id());
            })
            ->with('siswa.user'); // Pastikan relasi 'user' juga di-load untuk mengambil nama

        // 2. Tambahkan Filter Berdasarkan Nama Siswa
        if ($request->filled('nama_siswa')) {
            $namaSiswa = $request->input('nama_siswa');

            // Filter di relasi 'siswa' lalu ke relasi 'user' untuk mencari nama
            $kegiatans->whereHas('siswa.user', function ($query) use ($namaSiswa) {
                $query->where('name', 'like', '%' . $namaSiswa . '%');
            });
        }

        // 3. Tambahkan Filter Berdasarkan Tanggal Kegiatan
        if ($request->filled('tanggal')) {
            $kegiatans->whereDate('tanggal_kegiatan', $request->input('tanggal'));
        }

        // 4. Eksekusi query dengan urutan dan pengambilan data
        $kegiatans = $kegiatans->orderBy('id', 'desc')->get();

        return view('pembimbing.kegiatansiswa.index', compact('kegiatans'));
    }
    public function update(Request $request, $id)
    {
        // Mengambil objek berdasarkan ID
        $kegiatan = Kegiatan::findOrFail($id);

        $request->validate([
            'catatan_pembimbing' => 'nullable|string|max:500',
        ]);

        $kegiatan->catatan_pembimbing = $request->catatan_pembimbing;
        $kegiatan->save();

        return redirect()->back()->with('success', 'Catatan pembimbing berhasil diperbarui!');
    }
}

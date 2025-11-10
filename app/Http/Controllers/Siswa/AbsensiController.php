<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbsensiController extends Controller
{
    public function absensiAdmin(Request $request)
    {
        $absensi = Absensi::with('siswa')->get();
        return view('admin.absensis.absensi', compact('absensi'));
    }

    public function absensiPembimbing(Request $request)
    {
        $absensi = Absensi::with('siswa')->get();
        return view('pembimbing.absensis.absensi', compact('absensi'));
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $siswa = Auth::user()->siswa;

        // Ambil semua absensi milik siswa yang login
        $absensi = Absensi::where('id_siswa', $siswa->id)
            ->select('tanggal_absen', 'status', 'jam_mulai', 'jam_akhir', 'keterangan')
            ->get()
            ->map(function ($item) {
                // Tentukan warna badge sesuai status
                $warna = match ($item->status) {
                    'Hadir' => '#28a745',
                    'Izin' => '#007bff',
                    'Sakit' => '#dc3545',
                    default => '#6c757d',
                };

                return [
                    'tanggal_absen' => $item->tanggal_absen,
                    'status' => $item->status,
                    'jam_mulai' => $item->jam_mulai,
                    'jam_akhir' => $item->jam_akhir,
                    'keterangan' => $item->keterangan,
                    'warna' => $warna,
                ];
            });

        return view("siswa.absensi.index", [
            'absensi' => $absensi
        ]);
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    // ... dalam AbsensiController.php

    public function store(Request $request)
    {
        // 1. Validasi: Status dibuat nullable untuk memungkinkan update jam saja
        $request->validate([
            'tanggal_absen' => 'required|date',
            // Ubah status menjadi nullable
            'status' => 'nullable|in:hadir,izin,sakit,libur,alpha',
            'jam_mulai' => 'nullable|date_format:H:i',
            'jam_akhir' => 'nullable|date_format:H:i',
            'keterangan' => 'nullable|string',
        ]);

        $siswa = Auth::user()->siswa;

        // Cari data absensi yang sudah ada
        $absen = Absensi::where('id_siswa', $siswa->id)
            ->whereDate('tanggal_absen', $request->tanggal_absen)
            ->first();

        // --- LOGIKA UTAMA ---

        if ($absen) {
            // KASUS 1: Data Absensi SUDAH ADA (Update)

            // A. Update Jam (Dilakukan jika status sudah Hadir)
            // Kita hanya melakukan update jam jika statusnya memang 'Hadir' dan jam dikirimkan
            // ... dalam AbsensiController.php

            // A. Update Jam (Dilakukan jika status sudah Hadir)
            if ($absen->status === 'hadir' && ($request->filled('jam_mulai') || $request->filled('jam_akhir') || $request->has('jam_mulai') || $request->has('jam_akhir'))) {
                // UBAH KE HURUF KECIL

                // Gunakan operator ternary untuk mengubah string kosong menjadi null
                $jamMulai = $request->jam_mulai ? $request->jam_mulai : null;
                $jamAkhir = $request->jam_akhir ? $request->jam_akhir : null;

                // Lakukan update HANYA jika setidaknya salah satu jam terisi (atau kita biarkan null jika kosong)
                if ($jamMulai || $jamAkhir) {
                    $absen->update([
                        'jam_mulai' => $jamMulai,
                        'jam_akhir' => $jamAkhir,
                        // Status dan Keterangan tidak diubah
                    ]);
                    return redirect()->back()->with('success', 'Jam absensi berhasil diperbarui.');
                }
                // Jika tidak ada jam yang dikirimkan meskipun HadirBox aktif, biarkan saja (jangan update)
                return redirect()->back()->with('warning', 'Tidak ada nilai jam yang dikirim untuk diperbarui.')->withInput();
            }

            // B. Update Status (Dilakukan jika status baru dikirim melalui radio)
            if ($request->filled('status') && $request->status !== $absen->status) {
                // Ini adalah perubahan status (misal dari Hadir ke Izin/Sakit, atau sebaliknya)
                $absen->update([
                    'status' => $request->status,
                    'jam_mulai' => $request->status === 'hadir' ? $request->jam_mulai : null, // UBAH KE HURUF KECIL
                    'jam_akhir' => $request->status === 'hadir' ? $request->jam_akhir : null,   // UBAH KE HURUF KECIL
                    'keterangan' => ($request->status === 'izin' || $request->status === 'sakit') ? $request->keterangan : null, // UBAH KE HURUF KECIL
                ]);
                return redirect()->back()->with('success', 'Status absensi berhasil diperbarui.');
            }

            // Jika tidak ada perubahan yang signifikan dikirim (misalnya hanya klik submit tanpa mengisi apa-apa)
            return redirect()->back()->with('warning', 'Tidak ada data yang diperbarui.')->withInput();
        } else {
            // KASUS 2: Data Absensi BELUM ADA (Create Baru)

            // Saat pertama kali submit, kita hanya butuh status. Jam bisa diabaikan.
            if (!$request->filled('status')) {
                return redirect()->back()->with('error', 'Silakan pilih status absensi.')->withInput();
            }

            Absensi::create([
                'id_siswa' => $siswa->id,
                'tanggal_absen' => $request->tanggal_absen,
                'status' => $request->status,
                // Saat Create, jam_mulai/akhir akan null jika sesuai logika view Anda (saat pilih Hadir pertama kali)
                'jam_mulai' => $request->status === 'hadir' ? $request->jam_mulai : null, // UBAH KE HURUF KECIL
                'jam_akhir' => $request->status === 'hadir' ? $request->jam_akhir : null,   // UBAH KE HURUF KECIL
                // ...
                'keterangan' => $request->filled('keterangan') ? $request->keterangan : null,
            ]);

            return redirect()->back()->with('success', 'Absensi berhasil disimpan.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

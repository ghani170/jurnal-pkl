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

    /**
     * Store a newly created resource in storage.
     */
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validasi
        $request->validate([
            'tanggal_absen' => 'required|date',
            'status' => 'nullable|in:hadir,izin,sakit,libur,alpha', 
            'jam_mulai' => 'nullable|date_format:H:i',
            'jam_akhir' => 'nullable|date_format:H:i',
            'keterangan' => 'nullable|string',
        ]);

        $siswa = Auth::user()->siswa;

        // Cari data absensi yang sudah ada untuk hari ini
        $absen = Absensi::where('id_siswa', $siswa->id)
            ->whereDate('tanggal_absen', $request->tanggal_absen)
            ->first();

        // --- LOGIKA UTAMA ---

        if ($absen) {
            // KASUS 1: Data Absensi SUDAH ADA (Update)
            $statusDB = strtolower($absen->status); 
            $dataToUpdate = [];

            // A. Update Jam (Hanya dilakukan jika status di DB adalah 'hadir')
            if ($statusDB === 'hadir') {
                
                // Jika $request->jam_mulai terisi, gunakan nilainya. 
                // Jika string kosong (''), gunakan nilai lama dari DB.
                // Jika tidak ada dalam request (misal tidak ada di form), gunakan nilai lama dari DB.
                
                // Gunakan $request->get() untuk mengambil nilai, string kosong ('') akan tetap menjadi string kosong
                $jamMulaiRequest = $request->get('jam_mulai');
                $jamAkhirRequest = $request->get('jam_akhir');
                
                // Logika utama: Pertahankan nilai lama jika request kosong/null
                $jamMulaiBaru = ($jamMulaiRequest === null || $jamMulaiRequest === '') 
                                ? $absen->jam_mulai 
                                : $jamMulaiRequest;
                
                $jamAkhirBaru = ($jamAkhirRequest === null || $jamAkhirRequest === '') 
                                ? $absen->jam_akhir 
                                : $jamAkhirRequest;

                // Cek apakah ada perubahan (pastikan kedua nilai berbeda sebelum update)
                $isJamMulaiChanged = ($jamMulaiBaru !== $absen->jam_mulai);
                $isJamAkhirChanged = ($jamAkhirBaru !== $absen->jam_akhir);

                if ($isJamMulaiChanged || $isJamAkhirChanged) {
                    $dataToUpdate['jam_mulai'] = $jamMulaiBaru;
                    $dataToUpdate['jam_akhir'] = $jamAkhirBaru;
                    
                    // Lakukan Update
                    $absen->update($dataToUpdate);
                    return redirect()->back()->with('success', 'Jam absensi berhasil diperbarui.');
                }
            }


            // B. Update Status (Dilakukan jika status baru dikirim melalui radio dan berbeda)
            if ($request->filled('status') && $request->status !== $statusDB) {
                
                $absen->update([
                    'status' => $request->status,
                    
                    // Reset jam jika status berubah dari 'hadir' ke yang lain (izin/sakit)
                    // Atau isi jam jika status berubah menjadi 'hadir'
                    'jam_mulai' => $request->status === 'hadir' ? $request->jam_mulai : null, 
                    'jam_akhir' => $request->status === 'hadir' ? $request->jam_akhir : null,  
                    
                    'keterangan' => ($request->status === 'izin' || $request->status === 'sakit') ? $request->keterangan : null,
                ]);
                return redirect()->back()->with('success', 'Status absensi berhasil diperbarui.');
            }

            // Jika tidak ada perubahan jam maupun status yang terdeteksi
            return redirect()->back()->with('warning', 'Tidak ada data yang diperbarui.')->withInput();
            
        } else {
            // KASUS 2: Data Absensi BELUM ADA (Create Baru)

            if (!$request->filled('status')) {
                return redirect()->back()->with('error', 'Silakan pilih status absensi.')->withInput();
            }
            
            $statusToSave = ucfirst($request->status); 

            Absensi::create([
                'id_siswa' => $siswa->id,
                'tanggal_absen' => $request->tanggal_absen,
                'status' => $statusToSave, 
                // Saat CREATE, jam_mulai/akhir di set NULL kecuali sudah diisi di form awal
                'jam_mulai' => $request->status === 'hadir' && $request->filled('jam_mulai') ? $request->jam_mulai : null, 
                'jam_akhir' => $request->status === 'hadir' && $request->filled('jam_akhir') ? $request->jam_akhir : null,  
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

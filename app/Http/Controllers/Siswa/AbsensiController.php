<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use Carbon\Carbon;
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
                    'hadir' => '#28a745',
                    'izin' => '#007bff',
                    'sakit' => '#dc3545',
                    'libur' => '#ffc107', 
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
     *
     * @param int $siswaId 
     * @param string $tanggalAbsenHariIni 
     */
    private function autoFillAbsensi($siswaId, $tanggalAbsenHariIni)
    {
        
        $tanggalAwalPengecekan = Carbon::parse($tanggalAbsenHariIni)->subDays(100)->toDateString(); 
        
        $tanggalAkhirPengecekan = Carbon::parse($tanggalAbsenHariIni)->subDay()->toDateString();

        if ($tanggalAwalPengecekan > $tanggalAkhirPengecekan) {
            return; 
        }

        
        $absensiSudahAda = Absensi::where('id_siswa', $siswaId)
            ->whereBetween('tanggal_absen', [$tanggalAwalPengecekan, $tanggalAkhirPengecekan])
            ->pluck('tanggal_absen')
            ->map(fn($date) => Carbon::parse($date)->toDateString())
            ->toArray();

        $dataIsianOtomatis = [];
        $periode = Carbon::parse($tanggalAwalPengecekan);
        $tanggalHariIni = Carbon::parse($tanggalAbsenHariIni);

        while ($periode->lessThan($tanggalHariIni)) {
            $tanggalCek = $periode->toDateString();
            
            
            if (!in_array($tanggalCek, $absensiSudahAda)) {
                $carbonDate = Carbon::parse($tanggalCek);
                $statusOtomatis = 'Alpha'; // Default status adalah Alpha
                $keterangan = 'Otomatis diatur menjadi Alpha setelah absen di ' . $tanggalAbsenHariIni;

                // Cek jika hari itu adalah Sabtu (6) atau Minggu (0)
                if ($carbonDate->isSaturday() || $carbonDate->isSunday()) {
                    $statusOtomatis = 'Libur';
                    $keterangan = $carbonDate->isSaturday() ? 'Libur (Sabtu) otomatis' : 'Libur (Minggu) otomatis';
                }

                $dataIsianOtomatis[] = [
                    'id_siswa' => $siswaId,
                    'tanggal_absen' => $tanggalCek,
                    'status' => $statusOtomatis, 
                    'created_at' => now(),
                    'updated_at' => now(),
                    'keterangan' => $keterangan,
                ];
            }
            $periode->addDay();
        }

        // Masukkan semua data yang baru ke database
        if (!empty($dataIsianOtomatis)) {
            Absensi::insert($dataIsianOtomatis);
        }
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
    public function store(Request $request)
    {
        // 1. Validasi
        $request->validate([
            'tanggal_absen' => 'required|date',
            // Pastikan 'libur' ada di sini
            'status' => 'nullable|in:hadir,izin,sakit,libur,alpha', 
            'jam_mulai' => 'nullable|date_format:H:i',
            'jam_akhir' => 'nullable|date_format:H:i',
            'keterangan' => 'nullable|string',
        ]);

        $siswa = Auth::user()->siswa;
        $tanggalAbsenHariIni = Carbon::parse($request->tanggal_absen)->toDateString();

        // Cari data absensi yang sudah ada untuk hari ini
        $absen = Absensi::where('id_siswa', $siswa->id)
            ->whereDate('tanggal_absen', $tanggalAbsenHariIni)
            ->first();
        
        $message = 'Absensi berhasil disimpan.';

        // --- LOGIKA UTAMA ---

        if ($absen) {
            // KASUS 1: Data Absensi SUDAH ADA (Update)
            $statusDB = strtolower($absen->status);
            $dataToUpdate = [];

            
            if ($statusDB === 'hadir') {
                $jamMulaiRequest = $request->get('jam_mulai');
                $jamAkhirRequest = $request->get('jam_akhir');

                $jamMulaiBaru = ($jamMulaiRequest === null || $jamMulaiRequest === '')
                    ? $absen->jam_mulai
                    : $jamMulaiRequest;

                $jamAkhirBaru = ($jamAkhirRequest === null || $jamAkhirRequest === '')
                    ? $absen->jam_akhir
                    : $jamAkhirRequest;

                $isJamMulaiChanged = ($jamMulaiBaru !== $absen->jam_mulai);
                $isJamAkhirChanged = ($jamAkhirBaru !== $absen->jam_akhir);

                if ($isJamMulaiChanged || $isJamAkhirChanged) {
                    $dataToUpdate['jam_mulai'] = $jamMulaiBaru;
                    $dataToUpdate['jam_akhir'] = $jamAkhirBaru;

                    $absen->update($dataToUpdate);
                    $message = 'Jam absensi berhasil diperbarui.';
                }
            }

            // B. Update Status (Dilakukan jika status baru dikirim melalui radio dan berbeda)
            if ($request->filled('status') && strtolower($request->status) !== $statusDB) {

                $absen->update([
                    'status' => ucfirst($request->status), // Simpan dengan huruf besar di awal
                    'jam_mulai' => $request->status === 'hadir' ? $request->jam_mulai : null,
                    'jam_akhir' => $request->status === 'hadir' ? $request->jam_akhir : null,
                    'keterangan' => ($request->status === 'izin' || $request->status === 'sakit') ? $request->keterangan : null,
                ]);
                $message = 'Status absensi berhasil diperbarui.';
            }

            if (!$request->filled('status') && !$isJamMulaiChanged && !$isJamAkhirChanged) {
                return redirect()->back()->with('warning', 'Tidak ada data yang diperbarui.')->withInput();
            }

        } else {
            // KASUS 2: Data Absensi BELUM ADA (Create Baru)

            if (!$request->filled('status')) {
                return redirect()->back()->with('error', 'Silakan pilih status absensi.')->withInput();
            }

            $statusToSave = ucfirst($request->status);

            // 1. Simpan Absensi Hari Ini
            Absensi::create([
                'id_siswa' => $siswa->id,
                'tanggal_absen' => $tanggalAbsenHariIni,
                'status' => $statusToSave,
                'jam_mulai' => $request->status === 'hadir' && $request->filled('jam_mulai') ? $request->jam_mulai : null,
                'jam_akhir' => $request->status === 'hadir' && $request->filled('jam_akhir') ? $request->jam_akhir : null,
                'keterangan' => $request->filled('keterangan') ? $request->keterangan : null,
            ]);

            $message = 'Absensi berhasil dicatat.';
        }

        // **3. Panggil Fungsi Otomatisasi (Berlaku untuk Create dan Update)**
        // Fungsi ini akan mengisi hari-hari yang kosong sebelumnya dengan 'Alpha' atau 'Libur'
        $this->autoFillAbsensi($siswa->id, $tanggalAbsenHariIni);
        
        $message .= ' Hari-hari sebelumnya yang kosong telah diisi dengan Alpha atau Libur (Sabtu/Minggu).';
        
        return redirect()->back()->with('success', $message);
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
<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $siswa = $user->siswa;

        // Ambil semua absensi milik siswa
        $absens = $siswa->absensi;

        // Format data untuk FullCalendar
        $events = $absens->map(function ($absen) {
            return [
                'id' => $absen->id,
                'title' => ucfirst($absen->status),
                'start' => $absen->tanggal_absen,
                'color' => match ($absen->status) {
                    'hadir' => '#28a745',
                    'izin' => '#ffc107',
                    'sakit' => '#17a2b8',
                    'alpha' => '#dc3545',
                    default => '#6c757d',
                },
            ];
        });

        // Jika request AJAX (FullCalendar)
        if ($request->ajax() || $request->has('ajax')) {
            return response()->json($events);
        }


        // Render view utama
        return view('siswa.absensi.index',compact('events'));
    }

    public function getByDate(Request $request)
    {
        $tanggal = $request->input('tanggal');
        $user = auth()->user();

        $siswa = $user->siswa;
        $idSiswa = $siswa->id_siswa ?? null; 

        if (!$idSiswa) {
            return response()->json(['error' => 'Siswa tidak ditemukan.'], 404);
        }

        $absen = Absensi::where('id_siswa', $idSiswa)
            ->whereDate('tanggal_absen', $tanggal)
            ->first();

        if ($absen) {
            return response()->json([
                'status' => $absen->status,
                'keterangan' => $absen->keterangan,
                'tanggal_absen' => $absen->tanggal_absen,
                'jam_mulai' => $absen->jam_mulai,
                'jam_akhir' => $absen->jam_akhir,
            ]);
        }

        return response()->json(null);
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal_absen' => 'required|date',
            'status' => 'required|in:hadir,sakit,izin,alpha',
            'keterangan' => 'nullable|string',
        ]);

        $siswa = auth()->user()->siswa ?? null;
        if (!$siswa) {
            return response()->json(['error' => 'Data siswa tidak ditemukan'], 404);
        }

        Absensi::updateOrCreate(
            [
                'tanggal_absen' => $request->tanggal_absen,
                'id_siswa' => $siswa->id, // 
            ],
            [
                'jam_mulai' => now()->format('H:i'),
                'jam_akhir' => now()->format('H:i'),
                'status' => $request->status,
                'keterangan' => $request->keterangan,
            ]
        );

        return response()->json(['success' => true]);
    }
}

<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class KegiatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        $siswa = $user->siswa;
        $kegiatan = $siswa->kegiatan;
        $query = $siswa->kegiatan(); // Pakai relasi eloquent, bukan langsung $siswa->kegiatan

        if ($request->bulan) {
            $query->whereMonth('tanggal_kegiatan', $request->bulan);
        }

        if ($request->tahun) {
            $query->whereYear('tanggal_kegiatan', $request->tahun);
        }

        $kegiatan = $query->orderBy('tanggal_kegiatan', 'desc')->get();
        return view('siswa.kegiatan.index', compact('kegiatan', 'user', 'siswa'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('siswa.kegiatan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $siswa = $user->siswa;

        $request->validate([
            'tanggal_kegiatan',
            'mulai_kegiatan',
            'akhir_kegiatan' => 'required|after:mulai_kegiatan',
            'keterangan_kegiatan',
            'dokumentasi' => 'required|image|mimes:jpg,png,jpeg',
            'catatan_kegiatan',
        ]);

        $data = [
            'id_siswa' => $siswa->id,
            'tanggal_kegiatan' => $request->tanggal_kegiatan,
            'mulai_kegiatan' => $request->mulai_kegiatan,
            'akhir_kegiatan' => $request->akhir_kegiatan,
            'keterangan_kegiatan' => $request->keterangan_kegiatan,
            'dokumentasi' => $request->dokumentasi,
            'catatan_kegiatan' => $request->catatan_kegiatan,
        ];

        if ($request->hasFile('dokumentasi')) {
            $imagePath = $request->file('dokumentasi')->store('dokumentasi', 'public');
            $data['dokumentasi'] = $imagePath;
        }

        Kegiatan::create($data);

        return redirect()->route('siswa.kegiatan.index')->with('success', 'data kegiatan berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */


    public function show($id)
    {
        $kegiatan = Kegiatan::findOrFail($id);

        return view('siswa.kegiatan.show', compact('kegiatan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $kegiatan = Kegiatan::findOrFail($id);
        return view('siswa.kegiatan.edit', compact('kegiatan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'keterangan_kegiatan' => 'required',
            'tanggal_kegiatan' => 'required|date',
            'mulai_kegiatan' => 'required|date_format:H:i',
            'akhir_kegiatan' => 'required|date_format:H:i',
            'dokumentasi' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',

        ]);

        $kegiatan = Kegiatan::findOrFail($id);

        if ($request->hasFile('dokumentasi')) {
            
            if ($kegiatan->dokumentasi && Storage::disk('public')->exists($kegiatan->dokumentasi)) {
                Storage::disk('public')->delete($kegiatan->dokumentasi);
            }

            
            $file = $request->file('dokumentasi');
            $path = $file->store('kegiatan', 'public');
            $kegiatan->dokumentasi = $path;
        }

        $kegiatan->keterangan_kegiatan = $request->keterangan_kegiatan;
        $kegiatan->tanggal_kegiatan = $request->tanggal_kegiatan;
        $kegiatan->mulai_kegiatan = $request->mulai_kegiatan;
        $kegiatan->akhir_kegiatan = $request->akhir_kegiatan;


        $kegiatan->save();

        return redirect()->route('siswa.kegiatan.index')->with('success', 'data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $kegiatan = Kegiatan::findOrFail($id);

        if ($kegiatan->dokumentasi && Storage::disk('public')->exists($kegiatan->dokumentasi)) {
            Storage::disk('public')->delete($kegiatan->dokumentasi);
        }

        $kegiatan->delete();
        return redirect()->route('siswa.kegiatan.index')->with('success', 'data kegiatan berhasil dihapus');
    }
}

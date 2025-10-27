<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Dudi;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfilSIswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $datasiswa = Siswa::where('id_siswa', $user->id)->first();
        $kela = Kelas::all();
        $pembimbing = User::where('role', 'pembimbing')->get();
        $jurusan = Jurusan::all();
        $dudi = Dudi::all();
        return view('siswa.kelolaprofil.index', compact('user', 'datasiswa', 'kela', 'jurusan', 'pembimbing', 'dudi'));
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
        //
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
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update([
            'name' => $request->name,
        ]);

        $datasiswa = Siswa::where('id_siswa', $user->id)->first();
        if ($datasiswa) {
            $datasiswa->update([
                'id_kelas' => $request->id_kelas,
                'id_jurusan' => $request->id_jurusan,
                'id_dudi' => $request->id_dudi,
                'id_pembimbing' => $request->id_pembimbing,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'alamat' => $request->alamat,
                'golongan_darah' => $request->golongan_darah,
                'no_telpon' => $request->no_telpon,
                'gender' => $request->gender,
            ]);
        }

        return redirect()->route('siswa.profil.index')->with('success', 'Profil berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

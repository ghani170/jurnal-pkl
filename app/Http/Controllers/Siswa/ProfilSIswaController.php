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
use Illuminate\Support\Facades\Hash;

class ProfilSIswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $siswa = $user->siswa;
        
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


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user = User::findOrFail($id);

        $userData =[
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        $user->update($userData);

        $datasiswa = Siswa::where('id_siswa', $user->id)->first();

        if ($datasiswa) {
            $updateDataSiswa = [
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'alamat' => $request->alamat,
                'golongan_darah' => $request->golongan_darah,
                'no_telpon' => $request->no_telpon,
                'gender' => $request->gender,
            ];

            if ($request->hasFile('foto')) {

                if ($datasiswa->foto) {
                    $old_path = public_path('uploads/profil/' . $datasiswa->foto);
                    if (file_exists($old_path)) {
                        unlink($old_path);
                    }
                }

                $image = $request->file('foto');
                $image_name = time() . '_' . $image->getClientOriginalName();

                $image->move(public_path('uploads/profil'), $image_name);

                $updateDataSiswa['foto'] = $image_name;
            }

            $datasiswa->update($updateDataSiswa);
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

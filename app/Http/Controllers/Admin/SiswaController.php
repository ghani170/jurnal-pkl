<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dudi;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SiswaController extends Controller
{
    public function index()
    {
        $siswa = Siswa::with('user', 'kelas', 'jurusan', 'dudi', 'pembimbing')->get();
        
        return view('admin.kelolasiswa.kelolasiswa', compact('siswa'));
    }

    public function create()
    {
        $kela = Kelas::all();
        $jurusan = Jurusan::all();
        $dudi = Dudi::all();
        $pembimbing =  User::where('role', 'pembimbing')->get();
        return view('admin.kelolasiswa.tambahsiswa', compact('kela', 'jurusan', 'dudi', 'pembimbing'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|unique:users,email',
            'nis_siswa' => 'required|string|max:70',
            'id_kelas' => 'nullable|exists:kelas,id',
            'id_jurusan' => 'nullable|exists:jurusans,id',
            'id_dudi' => 'nullable|exists:dudis,id',
            'id_pembimbing' => 'nullable|exists:users,id',
            'gender' => 'nullable|in:laki_laki,perempuan',
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'alamat' => 'nullable|string',
            'golongan_darah' => 'nullable|string|max:10',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'siswa',
        ]);

        Siswa::create([
            'id_siswa' => $user->id,
            'nis_siswa' => $request->nis_siswa,
            'id_kelas' => $request->id_kelas,
            'id_jurusan' => $request->id_jurusan,
            'id_dudi' => $request->id_dudi,
            'id_pembimbing' => $request->id_pembimbing,
            'gender' => $request->gender,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat' => $request->alamat,
            'golongan_darah' => $request->golongan_darah,

        ]);

        return redirect()->route('admin.siswa.index')->with('success', 'siswa berhasil dibuat');
    }

    public function edit($id)
    {
        
        $siswa = User::findOrFail($id);
        $datasiswa = Siswa::where('id_siswa', $siswa->id)->first(); 
        $kela = Kelas::all();
        $jurusan = Jurusan::all();
        $dudi = Dudi::all();
        $pembimbing = User::where('role', 'pembimbing')->get();

        return view('admin.kelolasiswa.editsiswa', compact('siswa', 'datasiswa', 'kela', 'jurusan', 'dudi', 'pembimbing'));
    }
    
    public function update(Request $request, User $siswa)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $siswa->id,
            'nis_siswa' => 'required|string|max:70|unique:siswas,nis_siswa,' . $siswa->siswa->id,
            'id_kelas' => 'nullable|exists:kelas,id',
            'id_jurusan' => 'nullable|exists:jurusans,id',
            'id_dudi' => 'nullable|exists:dudis,id',
            'id_pembimbing' => 'nullable|exists:users,id',
        ]);

        $user = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $user['password'] = Hash::make($request->password);
        }

        $siswa->update($user);

        if ($siswa->siswa) {
            $siswa->siswa->update([
                'nis_siswa' => $request->nis_siswa,
                'id_kelas' => $request->id_kelas,
                'id_jurusan' => $request->id_jurusan,
                'id_dudi' => $request->id_dudi,
                'id_pembimbing' => $request->id_pembimbing,
            ]);
        }

    return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil diupdate');
    }

    public function destroy($id){
        $user = User::find($id);
        if ($user) {
            $user->delete();
            return redirect()->route('admin.siswa.index')->with('success', 'data siswa berhasil dihapus');
        }
    }
}

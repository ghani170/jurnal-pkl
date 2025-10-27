<?php

namespace App\Http\Controllers;

use App\Models\Dudi;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function AdminDashboard()
    {
        $totalSiswa = User::where('role', 'siswa')->count();
        $totalPembimbing = User::where('role', 'pembimbing')->count();
        $totalDudi = Dudi::count();
        $totalKelas = Kelas::count();
        return view('admin.dashboard', compact('totalSiswa','totalPembimbing', 'totalDudi', 'totalKelas'));
    }

    public function KelolaSiswa()
    {
        $siswa = User::where('role', 'siswa')->get();
        return view('admin.kelolasiswa.kelolasiswa', compact('siswa'));
    }

    public function TambahSiswa(){
        return view('admin.kelolasiswa.tambahsiswa');
    }

    public function TambahSiswaStore(Request $request) {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|unique:users,email',
        ]);

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'siswa',
        ]);

        return redirect()->route('admin.kelolasiswa')->with('success', 'siswa berhasil dibuat');

    }

    public function KelolaPembimbing()
    {
        $pembimbing = User::where('role', 'pembimbing')->get();
        return view('admin.kelolapembimbing.index', compact('pembimbing'));
    }

    public function TambahPembimbing(){
        return view('admin.kelolapembimbing.tambah');
    }

    public function TambahPembimbingStore(Request $request) {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|unique:users,email',
        ]);

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'pembimbing',
        ]); 

        return redirect()->route('admin.kelolapembimbing')->with('success', 'pembimbing berhasil dibuat');

    }

    public function KelolaJurusan(){
        $jurusan = Jurusan::all();
        return view('admin.kelolajurusan.index', compact('jurusan'));
    }

    public function TambahJurusan(){
        return view('admin.kelolajurusan.tambah');
    }

    public function TambahJurusanStore(Request $request) {
        $data = $request->validate([
            'jurusan' => 'required|string|max:255|unique:jurusans,jurusan',
        ]);

        Jurusan::create([
            'jurusan' => $data['jurusan'],
        ]);

        return redirect()->route('admin.kelolajurusan')->with('success', 'jurusan berhasil dibuat');

    }


    public function inde(){
        $user = Auth::user();

        if($user->role === 'admin'){
            return view('admin.dashboard', compact('user'));
        }elseif($user->role === 'pembimbing'){
            return view('admin.pembimbing', compact('pembimbing'));
        }elseif($user->role === 'siswa'){
            return view('admin.siswa', compact('siswa'));
        }else{
            abort(403, 'Role pengguna tdak dikenal');
        }
    }
}

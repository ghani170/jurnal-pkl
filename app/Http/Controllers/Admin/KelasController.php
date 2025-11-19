<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index(){
        $kelas = Kelas::all();
        return view('admin.kelolakelas.index', compact('kelas'));
    }

    public function create(){
        return view('admin.kelolakelas.tambah');
    }

    public function store(Request $request, Kelas $kelas){
        $data = $request->validate([
            'kelas' => 'required|string|max:255|unique:kelas,kelas,' . $kelas->id,
        ]);

        Kelas::create([
            'kelas' => $data['kelas'],
        ]);

        return redirect()->route('admin.kelas.index')->with('success', 'Kelas berhasil ditambahkan');
    }

    public function edit(Kelas $kela){
        return view('admin.kelolakelas.edit', compact('kela'));
    }

    public function update(Request $request, Kelas $kela){
        $data = $request->validate([
            'kelas' => 'required|string|max:255|unique:kelas,kelas,' . $kela->id, 
        ]);

        $kela->update([
            'kelas' => $data['kelas'],
        ]);

        return redirect()->route('admin.kelas.index')->with('success', 'data kelas berhasil diupdate');
    }

    public function destroy(Kelas $kela){
        
        if ($kela->siswas()->count() > 0) {
            return redirect()->route('admin.kelas.index')->with('error', 'Kelas tidak dapat dihapus karena masih masih memiliki siswa.');
        }
        $kela->delete();
        return redirect()->route('admin.kelas.index')->with('success', 'kelas berhasil dihapus');
    }
}

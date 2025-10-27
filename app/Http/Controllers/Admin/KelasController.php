<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use App\Models\Kelas;
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

    public function store(Request $request){
        $data = $request->validate([
            'kelas' => 'required|string|max:255',
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
            'kelas' => 'required|string|max:255' . $kela->id, 
        ]);

        $kela->update([
            'kelas' => $data['kelas'],
        ]);

        return redirect()->route('admin.kelas.index')->with('success', 'data kelas berhasil diupdate');
    }

    public function destroy(Kelas $kela){
        $kela->delete();
        return redirect()->route('admin.kelas.index')->with('success', 'kelas berhasil dihapus');
    }
}

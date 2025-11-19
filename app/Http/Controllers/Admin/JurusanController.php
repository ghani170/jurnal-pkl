<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use App\Models\Siswa;
use Illuminate\Http\Request;

class JurusanController extends Controller
{
    public function index(){
        $jurusan = Jurusan::all();
        return view('admin.kelolajurusan.index', compact('jurusan'));
    }

    public function create() {
        return view('admin.kelolajurusan.tambah');
    }

    public function store(Request $request, Jurusan $jurusan){
        $data = $request->validate([
            'jurusan' => 'required|string|max:255|unique:jurusans,jurusan,' . $jurusan->id,
        ]);

        Jurusan::create([
            'jurusan' => $data['jurusan'],
        ]);

        return redirect()->route('admin.jurusan.index')->with('success', 'jurusan berhasil dibuat');
    }

    public function edit(Jurusan $jurusan){
        
        return view('admin.kelolajurusan.edit', compact('jurusan'));
    }

    public function update(Request $request, Jurusan $jurusan){
        $data = $request->validate([
            'jurusan' => 'required|string|max:255|unique:jurusans,jurusan,' . $jurusan->id,
        ]);

        $jurusan->update([
            'jurusan' => $data['jurusan'],
        ]);

        return redirect()->route('admin.jurusan.index')->with('success', 'jurusan berhasil di update');
    }

    public function destroy(Jurusan $jurusan){
        $hasJurusan = Siswa::where('id_jurusan', $jurusan->id)->exists();
        if ($hasJurusan) {
            return redirect()->route('admin.jurusan.index')->with('error', 'Jurusan tidak dapat dihapus karena masih masih memiliki siswa.');
        }
        $jurusan->delete();
        return redirect()->route('admin.jurusan.index')->with('success', 'jurusan berhasil dihapus');
    }
}

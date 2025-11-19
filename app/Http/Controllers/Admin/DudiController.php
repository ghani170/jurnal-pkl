<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dudi;
use Illuminate\Http\Request;

class DudiController extends Controller
{
    public function index(){
        $dudi = Dudi::all();
        return view('admin.keloladudi.index', compact('dudi'));
    }

    public function create(){
        return view('admin.keloladudi.tambah');
    }

    public function store(Request $request, Dudi $dudi){
        $data = $request->validate([
            'nama_dudi' => 'required|string|max:150|unique:dudis,nama_dudi,' . $dudi->id,
            'jenis_usaha' => 'required|string|max:100',
            'alamat' => 'required|string|max:255',
            'kontak' => 'required|string|max:100',
            'nama_pimpinan' => 'required|string|max:100',
            'nama_pembimbing' => 'required|string|max:100',
        ]);

        Dudi::create([
            'nama_dudi' => $data['nama_dudi'],
            'jenis_usaha' => $data['jenis_usaha'],
            'alamat' => $data['alamat'],
            'kontak' => $data['kontak'],
            'nama_pimpinan' => $data['nama_pimpinan'],
            'nama_pembimbing' => $data['nama_pembimbing'],  
        ]);

        return redirect()->route('admin.dudi.index');
    }

    public function edit(Dudi $dudi){
        return view('admin.keloladudi.edit', compact('dudi'));
    }

    public function update(Request $request, Dudi $dudi){
      $data = $request->validate([
            'nama_dudi' => 'required|string|max:255|unique:dudis,nama_dudi,' . $dudi->id,
            'jenis_usaha' => 'required|string|max:100',
            'alamat' => 'required|string|max:255',
            'kontak' => 'required|string|max:100',
            'nama_pimpinan' => 'required|string|max:100',
            'nama_pembimbing' => 'required|string|max:100',
      ]);

      $dudi->update([
        'nama_dudi' => $data['nama_dudi'],
        'jenis_usaha' => $data['jenis_usaha'],
        'alamat' => $data['alamat'],
        'kontak' => $data['kontak'],
        'nama_pimpinan' => $data['nama_pimpinan'],
        'nama_pembimbing' => $data['nama_pembimbing'],
      ]);

      return redirect()->route('admin.dudi.index')->with('success', 'data dudi berhasil diedit');
    }

    public function destroy(Dudi $dudi){
        $dudi->delete();
        return redirect()->route('admin.dudi.index');
    }
}
